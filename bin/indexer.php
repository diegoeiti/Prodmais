<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\ElasticsearchService;
use App\LattesParser;

$config = require dirname(__DIR__) . '/config/config.php';
$lattesXmlPath = $config['data_paths']['lattes_xml'];
$indexName = $config['app']['index_name'];

$esService = new ElasticsearchService($config['elasticsearch']);

echo "Iniciando processo de indexação no Elasticsearch...\n";

// Verifica e apaga o índice antigo, se existir
if ($esService->indexExists($indexName)) {
    echo "Índice '{$indexName}' existente. Apagando...\n";
    $esService->deleteIndex($indexName);
}

echo "Criando novo índice: '{$indexName}'...\n";
$esService->createIndex($indexName);

$files = glob($lattesXmlPath . '/*.xml');

if (empty($files)) {
    echo "Nenhum arquivo XML encontrado em: {$lattesXmlPath}\n";
    exit;
}

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
    $esService->bulkIndex($indexName, $allProductions);
    echo "Indexação concluída com sucesso!\n";
} else {
    echo "Nenhuma produção encontrada para indexar.\n";
}
