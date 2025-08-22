<?php

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use App\ElasticsearchService;

$config = require dirname(__DIR__, 2) . '/config/config.php';

// Sanitiza os inputs
$program = filter_input(INPUT_GET, 'program', FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
$query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING); // Adiciona o termo de busca principal

$filters = array_filter([
    'program' => $program,
    'type' => $type,
    'year' => $year,
    'q' => $query // Adiciona ao array de filtros
]);

try {
    $esService = new ElasticsearchService($config['elasticsearch']);
    $results = $esService->search($config['app']['index_name'], $filters);

    echo json_encode($results->asArray());

} catch (\Exception $e) {
    http_response_code(500);
    error_log($e->getMessage()); 
    echo json_encode(['error' => 'Erro ao realizar a busca.', 'details' => $e->getMessage()]);
}