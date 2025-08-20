<?php

header('Content-Type: application/json');

require_once 'c:/app3/Prodmais/vendor/autoload.php';

use Prodmais\Elasticsearch\ElasticsearchService;

// Tratamento de erro básico para o caso de o autoload não existir
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    http_response_code(500);
    echo json_encode(['error' => 'Dependências não instaladas. Execute \'composer install\'.']);
    exit;
}

// Carrega a configuração
$config = require __DIR__ . '/../config/config.php';

// Sanitiza os inputs
$program = filter_input(INPUT_GET, 'program', FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1900, 'max_range' => 2100]]);

$filters = array_filter([
    'program' => $program,
    'type' => $type,
    'year' => $year
]);

try {
    $esService = new ElasticsearchService($config['elasticsearch'], $config['app']['index_name']);
    $results = $esService->search($filters);
    echo json_encode($results);
} catch (\Exception $e) {
    http_response_code(500);
    // Em produção, logar o erro em vez de expô-lo
    error_log($e->getMessage()); 
    echo json_encode(['error' => 'Erro ao conectar ou realizar a busca no serviço.', 'details' => $e->getMessage()]);
}

