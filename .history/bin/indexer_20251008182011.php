<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\ElasticsearchService;
use App\LattesParser;
use App\OpenAlexFetcher;
use App\PdfParser;

$config = require dirname(__DIR__) . '/config/config.php';
$lattesXmlPath = $config['data_paths']['lattes_xml'];
$indexName = $config['app']['index_name'];

$esService = new ElasticsearchService($config['elasticsearch']);
$openAlexFetcher = new OpenAlexFetcher();

echo "=== PRODMAIS - INDEXADOR DE PRODUÇÃO CIENTÍFICA ===\n";
echo "Iniciando processo de indexação no Elasticsearch...\n";

// Verifica e apaga o índice antigo, se existir
if ($esService->indexExists($indexName)) {
    echo "Índice '{$indexName}' existente. Apagando...\n";
    $esService->deleteIndex($indexName);
}

echo "Criando novo índice: '{$indexName}'...\n";
$esService->createIndex($indexName);

// Buscar arquivos XML e PDF
$xmlFiles = glob($lattesXmlPath . '/*.xml');
$pdfFiles = glob(dirname(__DIR__) . '/data/uploads/*.pdf');
$allFiles = array_merge($xmlFiles, $pdfFiles);

if (empty($allFiles)) {
    echo "Nenhum arquivo encontrado em: {$lattesXmlPath} ou data/uploads/\n";
    exit;
}

echo "Encontrados " . count($allFiles) . " arquivos para processamento.\n";

$lattesParser = new LattesParser();
$pdfParser = new PdfParser();
$allProductions = [];
$stats = [
    'files_processed' => 0,
    'productions_found' => 0,
    'enriched_with_openalex' => 0,
    'errors' => 0
];

foreach ($allFiles as $file) {
    echo "\n📄 Processando arquivo: " . basename($file) . "\n";
    
    try {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $productions = [];
        
        if ($extension === 'xml') {
            $productions = $lattesParser->parse($file);
            echo "   ✓ Extraídas " . count($productions) . " produções do XML Lattes\n";
        } elseif ($extension === 'pdf') {
            $productions = $pdfParser->parse($file);
            echo "   ✓ Extraídas " . count($productions) . " produções do PDF\n";
        }
        
        if (!empty($productions)) {
            // Enriquecer dados com OpenAlex (com throttling)
            echo "   🔍 Enriquecendo dados com OpenAlex...\n";
            $enrichedCount = 0;
            
            foreach ($productions as &$production) {
                try {
                    if (!empty($production['doi']) || !empty($production['title'])) {
                        $enrichedProduction = $openAlexFetcher->enrichProduction($production);
                        
                        if (isset($enrichedProduction['openalex_id'])) {
                            $enrichedCount++;
                            echo "     ↳ Enriquecido: " . substr($production['title'], 0, 50) . "...\n";
                        }
                        
                        $production = $enrichedProduction;
                        
                        // Rate limiting: 10 requests per second for OpenAlex
                        usleep(100000); // 0.1 second delay
                    }
                } catch (\Exception $e) {
                    echo "     ⚠️ Erro ao enriquecer produção: " . $e->getMessage() . "\n";
                }
            }
            
            echo "   ✓ {$enrichedCount} produções enriquecidas com dados do OpenAlex\n";
            
            $allProductions = array_merge($allProductions, $productions);
            $stats['enriched_with_openalex'] += $enrichedCount;
        }
        
        $stats['files_processed']++;
        $stats['productions_found'] += count($productions);
        
    } catch (\Exception $e) {
        echo "   ❌ Erro ao processar o arquivo " . basename($file) . ": " . $e->getMessage() . "\n";
        $stats['errors']++;
    }
}

echo "\n=== RESUMO DO PROCESSAMENTO ===\n";
echo "Arquivos processados: {$stats['files_processed']}\n";
echo "Produções encontradas: {$stats['productions_found']}\n";
echo "Enriquecidas com OpenAlex: {$stats['enriched_with_openalex']}\n";
echo "Erros: {$stats['errors']}\n";

if (!empty($allProductions)) {
    echo "\n🔄 Indexando " . count($allProductions) . " produções no Elasticsearch...\n";
    
    // Indexar em lotes para melhor performance
    $batchSize = 100;
    $totalBatches = ceil(count($allProductions) / $batchSize);
    $successfullyIndexed = 0;
    
    for ($i = 0; $i < $totalBatches; $i++) {
        $batch = array_slice($allProductions, $i * $batchSize, $batchSize);
        
        try {
            $response = $esService->bulkIndex($indexName, $batch);
            
            if ($response['errors']) {
                echo "   ⚠️ Lote " . ($i + 1) . "/{$totalBatches}: Alguns erros encontrados\n";
                foreach ($response['items'] as $item) {
                    if (isset($item['index']['error'])) {
                        echo "      - Erro: " . $item['index']['error']['type'] . " - " . $item['index']['error']['reason'] . "\n";
                    }
                }
            } else {
                echo "   ✓ Lote " . ($i + 1) . "/{$totalBatches}: " . count($batch) . " documentos indexados\n";
                $successfullyIndexed += count($batch);
            }
        } catch (\Exception $e) {
            echo "   ❌ Erro no lote " . ($i + 1) . "/{$totalBatches}: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n🔄 Forçando atualização do índice...\n";
    $esService->refreshIndex($indexName);
    
    echo "\n✅ INDEXAÇÃO CONCLUÍDA!\n";
    echo "Documentos indexados com sucesso: {$successfullyIndexed}\n";
    echo "Total de produções processadas: " . count($allProductions) . "\n";
    
    // Estatísticas finais
    echo "\n=== ESTATÍSTICAS FINAIS ===\n";
    try {
        $aggregations = $esService->getAggregations($indexName);
        $total = $aggregations['hits']['total']['value'] ?? 0;
        
        echo "Total de documentos no índice: {$total}\n";
        
        if (isset($aggregations['aggregations']['by_type']['buckets'])) {
            echo "\nDistribuição por tipo:\n";
            foreach ($aggregations['aggregations']['by_type']['buckets'] as $bucket) {
                echo "  - {$bucket['key']}: {$bucket['doc_count']}\n";
            }
        }
        
        if (isset($aggregations['aggregations']['by_year']['buckets'])) {
            $years = array_slice($aggregations['aggregations']['by_year']['buckets'], 0, 5);
            echo "\nÚltimos anos com mais produções:\n";
            foreach ($years as $bucket) {
                echo "  - {$bucket['key']}: {$bucket['doc_count']}\n";
            }
        }
        
    } catch (\Exception $e) {
        echo "Erro ao gerar estatísticas: " . $e->getMessage() . "\n";
    }
    
} else {
    echo "\n⚠️ Nenhuma produção encontrada para indexar.\n";
}

echo "\n🎉 Processo concluído! O sistema está pronto para uso.\n";
echo "Acesse: http://localhost:8000/index.php\n";
