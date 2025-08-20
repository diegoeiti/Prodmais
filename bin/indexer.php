<?php

require_once 'c:/app3/Prodmais/vendor/autoload.php';

use Prodmais\Elasticsearch\ElasticsearchService;
use Prodmais\Lattes\LattesParser;

// Carrega a configuração
$config = require __DIR__ . '/../config/config.php';

// Inicializa o serviço do Elasticsearch
$esService = new ElasticsearchService($config['elasticsearch'], $config['app']['index_name']);

// Caminho para os arquivos XML do Lattes
$lattesXmlPath = $config['data_paths']['lattes_xml'];

// Lógica para ler e processar os arquivos
echo "Iniciando processo de indexação...\n";

$files = glob($lattesXmlPath . '/*.xml');

if (empty($files)) {
    echo "Nenhum arquivo XML encontrado em: {$lattesXmlPath}\n";
    exit;
}

// Recria o índice para garantir que está limpo
echo "Recriando o índice '{$config['app']['index_name']}'...\n";
$esService->recreateIndex();

$lattesParser = new LattesParser();
$allProductions = [];

foreach ($files as $file) {
    echo "Processando arquivo: " . basename($file) . "\n";
    try {
        $productions = $lattesParser->parse($file);
        $allProductions = array_merge($allProductions, $productions);
    } catch (\Exception $e) {
        echo "Erro ao processar o arquivo " . basename($file) . ": " . $e->getMessage() . "\n";
    }
}

if (!empty($allProductions)) {
    echo "Indexando " . count($allProductions) . " produções no Elasticsearch...\n";
    $esService->bulkIndex($allProductions);
    echo "Indexação concluída com sucesso!\n";
} else {
    echo "Nenhuma produção encontrada para indexar.\n";
}

