<?php

/**
 * Gerenciador de Tarefas Automáticas do Prodmais
 * 
 * Este script executa tarefas de manutenção e sincronização
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Definir diretórios
define('BASE_DIR', dirname(__DIR__));
define('CONFIG_DIR', BASE_DIR . '/config');
define('DATA_DIR', BASE_DIR . '/data');

// Carregar configuração
$config_file = CONFIG_DIR . '/config.php';
if (!file_exists($config_file)) {
    die("Arquivo de configuração não encontrado.\n");
}

$config = require $config_file;

// Classe principal do gerenciador
class TaskManager 
{
    private $config;
    private $logFile;
    
    public function __construct($config) {
        $this->config = $config;
        $this->logFile = DATA_DIR . '/logs/tasks.log';
        
        // Criar diretório de logs se não existir
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
    }
    
    public function log($message, $level = 'INFO') {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$level] $message" . PHP_EOL;
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        if ($level === 'ERROR') {
            echo "ERRO: $message\n";
        } else {
            echo "$message\n";
        }
    }
    
    public function runCleanupTasks() {
        $this->log("Iniciando tarefas de limpeza");
        
        // Limpar logs antigos
        $this->cleanOldLogs();
        
        // Limpar cache antigo
        $this->cleanOldCache();
        
        // Limpar backups antigos
        $this->cleanOldBackups();
        
        $this->log("Tarefas de limpeza concluídas");
    }
    
    private function cleanOldLogs() {
        $retention_days = $this->config['logging']['max_files'] ?? 30;
        $logs_db = DATA_DIR . '/logs.sqlite';
        
        if (file_exists($logs_db)) {
            try {
                $pdo = new PDO("sqlite:$logs_db");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $cutoff_date = date('Y-m-d H:i:s', strtotime("-{$retention_days} days"));
                $stmt = $pdo->prepare("DELETE FROM logs WHERE timestamp < ?");
                $stmt->execute([$cutoff_date]);
                
                $deleted = $stmt->rowCount();
                $this->log("Removidos $deleted registros de log antigos");
                
            } catch (Exception $e) {
                $this->log("Erro ao limpar logs: " . $e->getMessage(), 'ERROR');
            }
        }
    }
    
    private function cleanOldCache() {
        $cache_dir = DATA_DIR . '/cache';
        $ttl = $this->config['cache']['ttl'] ?? 3600;
        $cutoff_time = time() - $ttl;
        
        if (is_dir($cache_dir)) {
            $files = glob($cache_dir . '/*');
            $deleted = 0;
            
            foreach ($files as $file) {
                if (is_file($file) && filemtime($file) < $cutoff_time) {
                    unlink($file);
                    $deleted++;
                }
            }
            
            $this->log("Removidos $deleted arquivos de cache antigos");
        }
    }
    
    private function cleanOldBackups() {
        if (!isset($this->config['backup']['enabled']) || !$this->config['backup']['enabled']) {
            return;
        }
        
        $backup_dir = $this->config['backup']['path'] ?? DATA_DIR . '/backups';
        $retention_days = $this->config['backup']['retention_days'] ?? 30;
        $cutoff_time = time() - ($retention_days * 24 * 60 * 60);
        
        if (is_dir($backup_dir)) {
            $files = glob("$backup_dir/*.tar.gz");
            $deleted = 0;
            
            foreach ($files as $file) {
                if (filemtime($file) < $cutoff_time) {
                    unlink($file);
                    $deleted++;
                }
            }
            
            $this->log("Removidos $deleted backups antigos");
        }
    }
    
    public function runSyncTasks() {
        $this->log("Iniciando tarefas de sincronização");
        
        // Sincronizar com OpenAlex
        if ($this->config['integrations']['openalex']['enabled'] ?? false) {
            $this->syncOpenAlex();
        }
        
        // Sincronizar com ORCID
        if ($this->config['integrations']['orcid']['enabled'] ?? false) {
            $this->syncOrcid();
        }
        
        $this->log("Tarefas de sincronização concluídas");
    }
    
    private function syncOpenAlex() {
        try {
            require_once BASE_DIR . '/src/OpenAlexFetcher.php';
            require_once BASE_DIR . '/src/ElasticsearchService.php';
            
            $es = new ElasticsearchService($this->config);
            $openAlex = new OpenAlexFetcher($this->config);
            
            // Buscar publicações sem dados do OpenAlex
            $search_params = [
                'index' => $this->config['app']['index_name'],
                'body' => [
                    'query' => [
                        'bool' => [
                            'must_not' => [
                                'exists' => ['field' => 'openalex_data']
                            ]
                        ]
                    ],
                    'size' => 100
                ]
            ];
            
            $response = $es->getClient()->search($search_params);
            
            if (isset($response['hits']['hits'])) {
                $updated = 0;
                
                foreach ($response['hits']['hits'] as $hit) {
                    $doc = $hit['_source'];
                    
                    // Tentar enriquecer com dados do OpenAlex
                    $enriched = $openAlex->enrichProduction($doc);
                    
                    if ($enriched !== $doc) {
                        // Atualizar documento
                        $es->getClient()->update([
                            'index' => $hit['_index'],
                            'id' => $hit['_id'],
                            'body' => ['doc' => $enriched]
                        ]);
                        $updated++;
                    }
                    
                    // Rate limiting
                    usleep(100000); // 100ms
                }
                
                $this->log("Sincronizados $updated registros com OpenAlex");
            }
            
        } catch (Exception $e) {
            $this->log("Erro na sincronização OpenAlex: " . $e->getMessage(), 'ERROR');
        }
    }
    
    private function syncOrcid() {
        try {
            require_once BASE_DIR . '/src/OrcidFetcher.php';
            require_once BASE_DIR . '/src/ElasticsearchService.php';
            
            $es = new ElasticsearchService($this->config);
            $orcid = new OrcidFetcher($this->config);
            
            // Buscar pesquisadores com ORCID mas sem dados atualizados
            $search_params = [
                'index' => $this->config['app']['index_name'],
                'body' => [
                    'query' => [
                        'bool' => [
                            'must' => [
                                'exists' => ['field' => 'orcid_id']
                            ],
                            'must_not' => [
                                'range' => [
                                    'orcid_last_update' => [
                                        'gte' => date('Y-m-d', strtotime('-7 days'))
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'size' => 50
                ]
            ];
            
            $response = $es->getClient()->search($search_params);
            
            if (isset($response['hits']['hits'])) {
                $updated = 0;
                
                foreach ($response['hits']['hits'] as $hit) {
                    $doc = $hit['_source'];
                    
                    if (isset($doc['orcid_id'])) {
                        $profile = $orcid->getCompleteProfile($doc['orcid_id']);
                        
                        if ($profile) {
                            $doc['orcid_data'] = $profile;
                            $doc['orcid_last_update'] = date('Y-m-d H:i:s');
                            
                            $es->getClient()->update([
                                'index' => $hit['_index'],
                                'id' => $hit['_id'],
                                'body' => ['doc' => $doc]
                            ]);
                            $updated++;
                        }
                    }
                    
                    // Rate limiting
                    sleep(1); // 1 segundo entre requisições
                }
                
                $this->log("Sincronizados $updated perfis ORCID");
            }
            
        } catch (Exception $e) {
            $this->log("Erro na sincronização ORCID: " . $e->getMessage(), 'ERROR');
        }
    }
    
    public function runBackupTask() {
        if (!isset($this->config['backup']['enabled']) || !$this->config['backup']['enabled']) {
            $this->log("Backup não habilitado na configuração");
            return;
        }
        
        $this->log("Iniciando backup automático");
        
        $backup_dir = $this->config['backup']['path'] ?? DATA_DIR . '/backups';
        if (!is_dir($backup_dir)) {
            mkdir($backup_dir, 0755, true);
        }
        
        $date = date('Y-m-d_H-i-s');
        $backup_file = "$backup_dir/prodmais_auto_backup_$date.tar.gz";
        
        $command = "tar -czf \"$backup_file\" " .
                   "--exclude=\"vendor\" " .
                   "--exclude=\".git\" " .
                   "--exclude=\"data/cache\" " .
                   "--exclude=\"data/backups\" " .
                   "-C " . BASE_DIR . " .";
        
        exec($command, $output, $return_code);
        
        if ($return_code === 0) {
            $this->log("Backup criado com sucesso: $backup_file");
        } else {
            $this->log("Erro ao criar backup", 'ERROR');
        }
    }
    
    public function getStatus() {
        $status = [
            'timestamp' => date('Y-m-d H:i:s'),
            'tasks' => []
        ];
        
        // Verificar Elasticsearch
        try {
            require_once BASE_DIR . '/src/ElasticsearchService.php';
            $es = new ElasticsearchService($this->config);
            $es->getClient()->ping();
            $status['elasticsearch'] = 'OK';
        } catch (Exception $e) {
            $status['elasticsearch'] = 'ERROR: ' . $e->getMessage();
        }
        
        // Verificar espaço em disco
        $free_space = disk_free_space(DATA_DIR);
        $total_space = disk_total_space(DATA_DIR);
        $usage_percent = round((($total_space - $free_space) / $total_space) * 100, 2);
        
        $status['disk_usage'] = [
            'free' => $this->formatBytes($free_space),
            'total' => $this->formatBytes($total_space),
            'usage_percent' => $usage_percent
        ];
        
        return $status;
    }
    
    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

// Executar tarefas baseado no argumento
$task_manager = new TaskManager($config);

$task = $argv[1] ?? 'help';

switch ($task) {
    case 'cleanup':
        $task_manager->runCleanupTasks();
        break;
        
    case 'sync':
        $task_manager->runSyncTasks();
        break;
        
    case 'backup':
        $task_manager->runBackupTask();
        break;
        
    case 'status':
        $status = $task_manager->getStatus();
        echo json_encode($status, JSON_PRETTY_PRINT) . "\n";
        break;
        
    case 'all':
        $task_manager->runCleanupTasks();
        $task_manager->runSyncTasks();
        $task_manager->runBackupTask();
        break;
        
    default:
        echo "Uso: php tasks.php [cleanup|sync|backup|status|all]\n\n";
        echo "Tarefas disponíveis:\n";
        echo "  cleanup - Limpar arquivos antigos e cache\n";
        echo "  sync    - Sincronizar com APIs externas\n";
        echo "  backup  - Criar backup do sistema\n";
        echo "  status  - Verificar status do sistema\n";
        echo "  all     - Executar todas as tarefas\n";
        break;
}