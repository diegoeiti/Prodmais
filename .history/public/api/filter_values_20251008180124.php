<?php

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use App\ElasticsearchService;

$config = require dirname(__DIR__, 2) . '/config/config.php';

$field = filter_input(INPUT_GET, 'field', FILTER_SANITIZE_STRING);
$size = filter_input(INPUT_GET, 'size', FILTER_VALIDATE_INT) ?: 100;

if (!$field) {
    http_response_code(400);
    echo json_encode(['error' => 'Campo é obrigatório']);
    exit;
}

// Mapeamento de campos permitidos
$allowedFields = [
    'type' => 'type',
    'subtype' => 'subtype',
    'language' => 'language',
    'institution' => 'institution.keyword',
    'year' => 'year',
    'journal' => 'journal.keyword',
    'publisher' => 'publisher.keyword',
    'city' => 'city',
    'state' => 'state',
    'country' => 'country'
];

if (!isset($allowedFields[$field])) {
    http_response_code(400);
    echo json_encode(['error' => 'Campo não permitido']);
    exit;
}

try {
    $esService = new ElasticsearchService($config['elasticsearch']);
    $values = $esService->getUniqueValues($config['app']['index_name'], $allowedFields[$field], $size);
    
    echo json_encode([
        'field' => $field,
        'values' => $values,
        'count' => count($values)
    ]);

} catch (\Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode([
        'error' => 'Erro ao buscar valores únicos',
        'details' => $e->getMessage()
    ]);
}