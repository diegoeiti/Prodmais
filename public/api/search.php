<?php

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use App\ElasticsearchService;

$config = require dirname(__DIR__, 2) . '/config/config.php';

// Sanitiza os inputs
$program = filter_input(INPUT_GET, 'program', FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);

$filters = array_filter([
    'program' => $program,
    'type' => $type,
    'year' => $year
]);

try {
    $esService = new ElasticsearchService($config['elasticsearch']);
    $results = $esService->search($config['app']['index_name'], $filters);

    echo json_encode($results);

} catch (\Exception $e) {
    http_response_code(500);
    error_log($e->getMessage()); 
    echo json_encode(['error' => 'Erro ao realizar a busca.', 'details' => $e->getMessage()]);
}