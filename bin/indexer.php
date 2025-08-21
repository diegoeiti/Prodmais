<?php

require_once dirname(__DIR__) . '/src/LattesParser.php';
require_once dirname(__DIR__) . '/src/JsonStorageService.php';

use Prodmais\JsonStorageService;
use Prodmais\Lattes\LattesParser;

// Caminho para o arquivo de banco de dados JSON
$dbPath = dirname(__DIR__) . '/data/db.json';
$lattesXmlPath = dirname(__DIR__) . '/data/lattes_xml';

// Inicializa o serviço de armazenamento
$storageService = new JsonStorageService($dbPath);

echo "Iniciando processo de criação do banco de dados JSON...\n";

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
    echo "Salvando " . count($allProductions) . " produções no arquivo db.json...\n";
    $storageService->recreateStorage($allProductions);
    echo "Banco de dados JSON criado com sucesso!\n";
} else {
    echo "Nenhuma produção encontrada para salvar.\n";
}