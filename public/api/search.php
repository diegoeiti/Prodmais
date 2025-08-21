<?php

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/src/JsonStorageService.php';

use Prodmais\JsonStorageService;

// Caminho para o arquivo de banco de dados JSON
$dbPath = dirname(__DIR__, 2) . '/data/db.json';

// Sanitiza os inputs
$program = filter_input(INPUT_GET, 'program', FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);

$filters = array_filter([
    // A filtragem de programa é um exemplo, precisaria de mais detalhes no XML
    // 'researcher_name' => $program, 
    'type' => $type,
    'year' => $year
]);

try {
    $storageService = new JsonStorageService($dbPath);
    $results = $storageService->search($filters);
    
    // A resposta precisa ter um formato similar ao do Elasticsearch para o frontend funcionar
    $formattedResults = [
        'hits' => [
            'total' => ['value' => count($results)],
            'hits' => array_map(function($item) {
                return ['_source' => $item];
            }, $results)
        ]
    ];

    echo json_encode($formattedResults);

} catch (\Exception $e) {
    http_response_code(500);
    error_log($e->getMessage()); 
    echo json_encode(['error' => 'Erro ao ler o banco de dados.']);
}