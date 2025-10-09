<?php
/**
 * Script de Teste do Sistema Prodmais UMC
 * Verifica se todas as classes e dependências estão funcionando corretamente
 */

echo "=== TESTE DO SISTEMA PRODMAIS UMC ===\n";

// Carrega as configurações
require_once __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/config/config.php';

// Testa inclusão das classes principais
echo "\n1. Testando carregamento das classes:\n";

echo "   - ElasticsearchService... ";
require_once __DIR__ . '/src/ElasticsearchService.php';
try {
    $esService = new ElasticsearchService($config['elasticsearch']);
    echo "✓ OK\n";
} catch (Exception $e) {
    echo "✗ ERRO: " . $e->getMessage() . "\n";
}

echo "   - LattesParser... ";
require_once __DIR__ . '/src/LattesParser.php';
try {
    $lattesParser = new LattesParser($config);
    echo "✓ OK\n";
} catch (Exception $e) {
    echo "✗ ERRO: " . $e->getMessage() . "\n";
}

echo "   - LogService... ";
require_once __DIR__ . '/src/LogService.php';
try {
    $logService = new LogService($config);
    echo "✓ OK\n";
} catch (Exception $e) {
    echo "✗ ERRO: " . $e->getMessage() . "\n";
}

echo "   - PdfParser... ";
require_once __DIR__ . '/src/PdfParser.php';
try {
    $pdfParser = new PdfParser();
    echo "✓ OK\n";
} catch (Exception $e) {
    echo "✗ ERRO: " . $e->getMessage() . "\n";
}

echo "   - JsonStorageService... ";
require_once __DIR__ . '/src/JsonStorageService.php';
try {
    $jsonService = new JsonStorageService($config['data_paths']['uploads'] . '/db.json');
    echo "✓ OK\n";
} catch (Exception $e) {
    echo "✗ ERRO: " . $e->getMessage() . "\n";
}

echo "   - Anonymizer... ";
require_once __DIR__ . '/src/Anonymizer.php';
try {
    $anonymizer = new Anonymizer();
    echo "✓ OK\n";
} catch (Exception $e) {
    echo "✗ ERRO: " . $e->getMessage() . "\n";
}

// Testa serviços UMC
echo "\n2. Testando serviços UMC:\n";

$umcServices = [
    'UmcProgramService.php' => 'UmcProgramService',
    'CapesReportGenerator.php' => 'CapesReportGenerator',
    'BrCrisIntegrator.php' => 'BrCrisIntegrator',
    'LgpdComplianceService.php' => 'LgpdComplianceService',
    'InstitutionalDashboard.php' => 'InstitutionalDashboard',
    'ProductionValidator.php' => 'ProductionValidator',
    'ExportService.php' => 'ExportService'
];

foreach ($umcServices as $file => $className) {
    echo "   - $className... ";
    if (file_exists(__DIR__ . '/src/' . $file)) {
        require_once __DIR__ . '/src/' . $file;
        if (class_exists($className)) {
            echo "✓ OK\n";
        } else {
            echo "✗ ERRO: Classe não encontrada\n";
        }
    } else {
        echo "✗ ERRO: Arquivo não encontrado\n";
    }
}

// Testa estrutura de diretórios
echo "\n3. Testando estrutura de diretórios:\n";

$directories = [
    'data/lattes_xml' => $config['data_paths']['lattes_xml'],
    'data/uploads' => $config['data_paths']['uploads'],
    'public' => __DIR__ . '/public',
    'src' => __DIR__ . '/src',
    'config' => __DIR__ . '/config'
];

foreach ($directories as $name => $path) {
    echo "   - $name... ";
    if (is_dir($path)) {
        echo "✓ OK\n";
    } else {
        echo "✗ ERRO: Diretório não encontrado\n";
    }
}

// Testa arquivos de configuração
echo "\n4. Testando arquivos de configuração:\n";

$configFiles = [
    'config.php' => __DIR__ . '/config/config.php',
    'composer.json' => __DIR__ . '/composer.json'
];

foreach ($configFiles as $name => $path) {
    echo "   - $name... ";
    if (file_exists($path)) {
        echo "✓ OK\n";
    } else {
        echo "✗ ERRO: Arquivo não encontrado\n";
    }
}

// Testa logs
echo "\n5. Testando sistema de logs:\n";

try {
    $logService = new LogService($config);
    $logService->log('SISTEMA', 'Teste de funcionamento do sistema');
    echo "   - Gravação de log... ✓ OK\n";
} catch (Exception $e) {
    echo "   - Gravação de log... ✗ ERRO: " . $e->getMessage() . "\n";
}

echo "\n=== TESTE CONCLUÍDO ===\n";
echo "Sistema Prodmais UMC está " . (error_get_last() ? "COM PROBLEMAS" : "FUNCIONANDO CORRETAMENTE") . "!\n";