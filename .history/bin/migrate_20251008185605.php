<?php

/**
 * Script de Migração e Atualização do Sistema Prodmais
 * 
 * Este script auxilia na migração de versões anteriores e atualizações
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Definir diretórios
define('BASE_DIR', dirname(__DIR__));
define('CONFIG_DIR', BASE_DIR . '/config');
define('DATA_DIR', BASE_DIR . '/data');

echo "========================================\n";
echo "  MIGRAÇÃO/ATUALIZAÇÃO - PRODMAIS      \n";
echo "========================================\n\n";

// Verificar se está rodando via CLI
if (php_sapi_name() !== 'cli') {
    die("Este script deve ser executado via linha de comando.\n");
}

// Carregar configuração
$config_file = CONFIG_DIR . '/config.php';
if (!file_exists($config_file)) {
    die("Arquivo de configuração não encontrado. Execute primeiro o script de instalação.\n");
}

$config = require $config_file;

echo "Sistema Prodmais - Versão: " . ($config['app']['version'] ?? 'Desconhecida') . "\n\n";

// Funções de migração
function migrateToV2($config) {
    echo "Executando migração para v2.0...\n";
    
    // Verificar se precisa migrar índices do Elasticsearch
    try {
        if (!class_exists('ElasticsearchService')) {
            require_once BASE_DIR . '/src/ElasticsearchService.php';
        }
        $es = new ElasticsearchService($config['elasticsearch']);
        
        // Verificar se índice antigo existe
        $old_index = 'prodmais'; // índice da versão antiga
        $new_index = $config['app']['index_name'];
        
        if ($old_index !== $new_index) {
            $response = $es->getClient()->indices()->exists(['index' => $old_index]);
            
            if ($response) {
                echo "Índice antigo encontrado. Iniciando migração de dados...\n";
                
                // Reindexar dados
                $reindex_body = [
                    'source' => ['index' => $old_index],
                    'dest' => ['index' => $new_index]
                ];
                
                $es->getClient()->reindex(['body' => $reindex_body, 'wait_for_completion' => true]);
                echo "✓ Dados migrados para novo índice: $new_index\n";
                
                // Opcional: remover índice antigo
                echo "Deseja remover o índice antigo '$old_index'? (s/N): ";
                $handle = fopen("php://stdin", "r");
                $response = trim(fgets($handle));
                fclose($handle);
                
                if (strtolower($response) === 's') {
                    $es->getClient()->indices()->delete(['index' => $old_index]);
                    echo "✓ Índice antigo removido\n";
                }
            }
        }
        
        // Atualizar mapeamentos
        echo "Atualizando mapeamentos do Elasticsearch...\n";
        $es->createIndex($new_index); // Recria o índice com novos mapeamentos
        echo "✓ Mapeamentos atualizados\n";
        
    } catch (Exception $e) {
        echo "⚠ Erro na migração do Elasticsearch: " . $e->getMessage() . "\n";
    }
    
    // Migrar estrutura de dados
    echo "Verificando estrutura de dados...\n";
    
    // Criar novos diretórios se não existirem
    $new_dirs = [
        DATA_DIR . '/cache',
        DATA_DIR . '/backups'
    ];
    
    foreach ($new_dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            echo "✓ Diretório criado: $dir\n";
        }
    }
    
    // Atualizar banco de logs
    $logs_db = DATA_DIR . '/logs.sqlite';
    try {
        $pdo = new PDO("sqlite:$logs_db");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verificar se novas colunas existem
        $result = $pdo->query("PRAGMA table_info(logs)");
        $columns = $result->fetchAll(PDO::FETCH_COLUMN, 1);
        
        if (!in_array('ip_address', $columns)) {
            $pdo->exec("ALTER TABLE logs ADD COLUMN ip_address VARCHAR(45)");
            echo "✓ Coluna 'ip_address' adicionada à tabela de logs\n";
        }
        
        if (!in_array('user_agent', $columns)) {
            $pdo->exec("ALTER TABLE logs ADD COLUMN user_agent TEXT");
            echo "✓ Coluna 'user_agent' adicionada à tabela de logs\n";
        }
        
    } catch (Exception $e) {
        echo "⚠ Erro na atualização do banco de logs: " . $e->getMessage() . "\n";
    }
    
    echo "✓ Migração para v2.0 concluída\n\n";
}

function updateComposerDependencies() {
    echo "Atualizando dependências...\n";
    
    // Verificar se composer.lock existe
    if (file_exists(BASE_DIR . '/composer.lock')) {
        echo "Executando: composer update\n";
        system('composer update --no-dev --optimize-autoloader');
    } else {
        echo "Executando: composer install\n";
        system('composer install --no-dev --optimize-autoloader');
    }
    
    echo "✓ Dependências atualizadas\n\n";
}

function clearCache() {
    echo "Limpando cache...\n";
    
    $cache_dir = DATA_DIR . '/cache';
    if (is_dir($cache_dir)) {
        $files = glob($cache_dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        echo "✓ Cache limpo\n";
    }
    
    echo "\n";
}

function reindexData($config) {
    echo "Deseja reindexar todos os dados? (s/N): ";
    $handle = fopen("php://stdin", "r");
    $response = trim(fgets($handle));
    fclose($handle);
    
    if (strtolower($response) === 's') {
        echo "Executando reindexação...\n";
        system('php ' . BASE_DIR . '/bin/indexer.php');
        echo "✓ Reindexação concluída\n";
    }
    
    echo "\n";
}

function backupBeforeMigration() {
    echo "Criando backup antes da migração...\n";
    
    $backup_dir = DATA_DIR . '/backups';
    if (!is_dir($backup_dir)) {
        mkdir($backup_dir, 0755, true);
    }
    
    $date = date('Y-m-d_H-i-s');
    $backup_file = "$backup_dir/pre_migration_backup_$date.tar.gz";
    
    $command = "tar -czf \"$backup_file\" " .
               "--exclude=\"vendor\" " .
               "--exclude=\".git\" " .
               "--exclude=\"data/cache\" " .
               "--exclude=\"data/backups\" " .
               "-C " . BASE_DIR . " .";
    
    system($command);
    echo "✓ Backup criado: $backup_file\n\n";
}

// Menu principal
echo "Selecione uma opção:\n";
echo "1. Migração completa para v2.0\n";
echo "2. Atualizar dependências apenas\n";
echo "3. Limpar cache\n";
echo "4. Reindexar dados\n";
echo "5. Criar backup\n";
echo "6. Sair\n\n";

echo "Opção: ";
$handle = fopen("php://stdin", "r");
$option = trim(fgets($handle));
fclose($handle);

switch ($option) {
    case '1':
        echo "\nIniciando migração completa...\n\n";
        backupBeforeMigration();
        updateComposerDependencies();
        migrateToV2($config);
        clearCache();
        reindexData($config);
        echo "Migração completa finalizada!\n";
        break;
        
    case '2':
        updateComposerDependencies();
        break;
        
    case '3':
        clearCache();
        break;
        
    case '4':
        reindexData($config);
        break;
        
    case '5':
        backupBeforeMigration();
        break;
        
    case '6':
        echo "Saindo...\n";
        break;
        
    default:
        echo "Opção inválida.\n";
        break;
}

echo "\nConcluído!\n";