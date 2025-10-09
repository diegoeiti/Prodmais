<?php

header('Content-Type: application/json');

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use App\ElasticsearchService;

$config = require dirname(__DIR__, 2) . '/config/config.php';

$query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
$area = filter_input(INPUT_GET, 'area', FILTER_SANITIZE_STRING);
$institution = filter_input(INPUT_GET, 'institution', FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_GET, 'city', FILTER_SANITIZE_STRING);
$size = filter_input(INPUT_GET, 'size', FILTER_VALIDATE_INT) ?: 20;

try {
    $esService = new ElasticsearchService($config['elasticsearch']);
    
    // Usar agregação para agrupar por pesquisador
    $filters = [];
    if ($area) $filters['area'] = $area;
    if ($institution) $filters['institution'] = $institution;
    
    $params = [
        'index' => $config['app']['index_name'],
        'body' => [
            'size' => 0, // Não retorna documentos, apenas agregações
            'query' => [
                'bool' => [
                    'must' => $query ? [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => ['researcher_name', 'institution']
                        ]
                    ] : [
                        'match_all' => new stdClass()
                    ],
                    'filter' => []
                ]
            ],
            'aggs' => [
                'researchers' => [
                    'terms' => [
                        'field' => 'researcher_name.keyword',
                        'size' => $size
                    ],
                    'aggs' => [
                        'latest_year' => [
                            'max' => ['field' => 'year']
                        ],
                        'production_count' => [
                            'value_count' => ['field' => 'id']
                        ],
                        'institutions' => [
                            'terms' => [
                                'field' => 'institution.keyword',
                                'size' => 5
                            ]
                        ],
                        'areas' => [
                            'nested' => [
                                'path' => 'areas'
                            ],
                            'aggs' => [
                                'area_breakdown' => [
                                    'terms' => [
                                        'field' => 'areas.grande_area',
                                        'size' => 5
                                    ]
                                ]
                            ]
                        ],
                        'types' => [
                            'terms' => [
                                'field' => 'type',
                                'size' => 10
                            ]
                        ],
                        'sample_doc' => [
                            'top_hits' => [
                                'size' => 1,
                                '_source' => ['researcher_lattes_id', 'institution', 'city', 'state', 'country']
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    
    // Aplicar filtros
    if ($area) {
        $params['body']['query']['bool']['filter'][] = [
            'nested' => [
                'path' => 'areas',
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => ['areas.grande_area' => $area]],
                            ['match' => ['areas.area' => $area]]
                        ]
                    ]
                ]
            ]
        ];
    }
    
    if ($institution) {
        $params['body']['query']['bool']['filter'][] = [
            'match' => ['institution' => $institution]
        ];
    }
    
    if ($city) {
        $params['body']['query']['bool']['filter'][] = [
            'term' => ['city' => $city]
        ];
    }
    
    $response = $esService->client->search($params);
    $result = $response->asArray();
    
    // Formatar resultado
    $researchers = [];
    if (!empty($result['aggregations']['researchers']['buckets'])) {
        foreach ($result['aggregations']['researchers']['buckets'] as $bucket) {
            $sampleDoc = $bucket['sample_doc']['hits']['hits'][0]['_source'] ?? [];
            
            $researchers[] = [
                'name' => $bucket['key'],
                'lattes_id' => $sampleDoc['researcher_lattes_id'] ?? null,
                'production_count' => $bucket['production_count']['value'],
                'latest_year' => $bucket['latest_year']['value'],
                'institutions' => array_map(function($inst) {
                    return $inst['key'];
                }, $bucket['institutions']['buckets']),
                'areas' => array_map(function($area) {
                    return $area['key'];
                }, $bucket['areas']['area_breakdown']['buckets']),
                'production_types' => array_map(function($type) {
                    return [
                        'type' => $type['key'],
                        'count' => $type['doc_count']
                    ];
                }, $bucket['types']['buckets']),
                'location' => [
                    'city' => $sampleDoc['city'] ?? null,
                    'state' => $sampleDoc['state'] ?? null,
                    'country' => $sampleDoc['country'] ?? null
                ]
            ];
        }
    }
    
    echo json_encode([
        'researchers' => $researchers,
        'total' => count($researchers),
        'filters_applied' => array_filter([
            'query' => $query,
            'area' => $area,
            'institution' => $institution,
            'city' => $city
        ])
    ], JSON_PRETTY_PRINT);

} catch (\Exception $e) {
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode([
        'error' => 'Erro ao buscar pesquisadores',
        'details' => $e->getMessage()
    ]);
}