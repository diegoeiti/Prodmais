<?php

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    private $client;
    private $fallbackMode = false;

    public function __construct(array $esConfig)
    {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts($esConfig['hosts'])
                ->setRetries(1)
                ->build();
            
            // Testa conexão
            $this->client->ping();
        } catch (Exception $e) {
            $this->fallbackMode = true;
            error_log("Elasticsearch não disponível, usando modo fallback: " . $e->getMessage());
        }
    }

    public function isFallbackMode(): bool
    {
        return $this->fallbackMode;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function indexExists(string $indexName): bool
    {
        $response = $this->client->indices()->exists(['index' => $indexName]);
        return $response->getStatusCode() === 200;
    }

    public function deleteIndex(string $indexName): void
    {
        $this->client->indices()->delete(['index' => $indexName]);
    }

    public function createIndex(string $indexName): void
    {
        $this->client->indices()->create([
            'index' => $indexName,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'id' => ['type' => 'keyword'],
                        'researcher_name' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'researcher_lattes_id' => ['type' => 'keyword'],
                        'title' => ['type' => 'text', 'analyzer' => 'portuguese'],
                        'year' => ['type' => 'integer'],
                        'type' => ['type' => 'keyword'],
                        'subtype' => ['type' => 'keyword'],
                        'doi' => ['type' => 'keyword'],
                        'language' => ['type' => 'keyword'],
                        'source' => ['type' => 'keyword'],
                        'institution' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'unit' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'city' => ['type' => 'keyword'],
                        'state' => ['type' => 'keyword'],
                        'country' => ['type' => 'keyword'],
                        'journal' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'publisher' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'isbn' => ['type' => 'keyword'],
                        'issn' => ['type' => 'keyword'],
                        'volume' => ['type' => 'keyword'],
                        'pages' => ['type' => 'keyword'],
                        'event_name' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'event_city' => ['type' => 'keyword'],
                        'event_year' => ['type' => 'keyword'],
                        'proceedings_title' => ['type' => 'text'],
                        'book_title' => ['type' => 'text'],
                        'student_name' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'course' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                        'patent_number' => ['type' => 'keyword'],
                        'purpose' => ['type' => 'text'],
                        'platform' => ['type' => 'keyword'],
                        'date' => ['type' => 'date', 'format' => 'yyyy-MM-dd||dd/MM/yyyy||strict_date_optional_time'],
                        'areas' => [
                            'type' => 'nested',
                            'properties' => [
                                'grande_area' => ['type' => 'keyword'],
                                'area' => ['type' => 'keyword'],
                                'sub_area' => ['type' => 'keyword'],
                                'especialidade' => ['type' => 'keyword']
                            ]
                        ],
                        'authors' => [
                            'type' => 'nested',
                            'properties' => [
                                'name' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                                'citation_name' => ['type' => 'text', 'fields' => ['keyword' => ['type' => 'keyword']]],
                                'order' => ['type' => 'integer']
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function bulkIndex(string $indexName, array $documents): array
    {
        $params = ['body' => []];

        foreach ($documents as $doc) {
            $params['body'][] = [
                'index' => [
                    '_index' => $indexName,
                    '_id'    => $doc['id']
                ]
            ];
            $params['body'][] = $doc;
        }

        $response = ['errors' => false];
        if (!empty($params['body'])) {
            $response = $this->client->bulk($params)->asArray();
        }
        return $response;
    }

    public function refreshIndex(string $indexName): void
    {
        $this->client->indices()->refresh(['index' => $indexName]);
    }

    public function search(string $indexName, array $filters = [], int $size = 50)
    {
        if ($this->fallbackMode) {
            return $this->searchFallback($filters, $size);
        }

        $must_query = [];
        $filter_query = [];

        // A busca por texto vai na cláusula principal
        if (!empty($filters['q'])) {
            $must_query[] = [
                'multi_match' => [
                    'query' => $filters['q'],
                    'fields' => ['title^2', 'researcher_name', 'journal', 'event_name', 'book_title', 'publisher'],
                    'type' => 'best_fields',
                    'fuzziness' => 'AUTO'
                ]
            ];
        } else {
            // Se não houver busca por texto, retorna tudo (respeitando os filtros)
            $must_query[] = ['match_all' => new \stdClass()];
        }

        // As seleções dos dropdowns vão na cláusula de filtro
        if (!empty($filters['type'])) {
            $filter_query[] = ['term' => ['type' => $filters['type']]];
        }
        if (!empty($filters['subtype'])) {
            $filter_query[] = ['term' => ['subtype' => $filters['subtype']]];
        }
        if (!empty($filters['year'])) {
            $filter_query[] = ['term' => ['year' => $filters['year']]];
        }
        if (!empty($filters['institution'])) {
            $filter_query[] = ['match' => ['institution' => $filters['institution']]];
        }
        if (!empty($filters['language'])) {
            $filter_query[] = ['term' => ['language' => $filters['language']]];
        }
        if (!empty($filters['area'])) {
            $filter_query[] = [
                'nested' => [
                    'path' => 'areas',
                    'query' => [
                        'bool' => [
                            'should' => [
                                ['match' => ['areas.grande_area' => $filters['area']]],
                                ['match' => ['areas.area' => $filters['area']]],
                                ['match' => ['areas.sub_area' => $filters['area']]]
                            ]
                        ]
                    ]
                ]
            ];
        }
        if (!empty($filters['author'])) {
            $filter_query[] = [
                'nested' => [
                    'path' => 'authors',
                    'query' => [
                        'multi_match' => [
                            'query' => $filters['author'],
                            'fields' => ['authors.name', 'authors.citation_name']
                        ]
                    ]
                ]
            ];
        }

        // Filtro por range de anos
        if (!empty($filters['year_from']) || !empty($filters['year_to'])) {
            $range_filter = ['range' => ['year' => []]];
            if (!empty($filters['year_from'])) {
                $range_filter['range']['year']['gte'] = (int)$filters['year_from'];
            }
            if (!empty($filters['year_to'])) {
                $range_filter['range']['year']['lte'] = (int)$filters['year_to'];
            }
            $filter_query[] = $range_filter;
        }

        $params = [
            'index' => $indexName,
            'body'  => [
                'size' => $size,
                'sort' => [
                    ['year' => ['order' => 'desc']],
                    ['_score' => ['order' => 'desc']]
                ],
                'query' => [
                    'bool' => [
                        'must' => $must_query,
                        'filter' => $filter_query
                    ]
                ],
                'highlight' => [
                    'fields' => [
                        'title' => new \stdClass(),
                        'researcher_name' => new \stdClass()
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }

    public function getAggregations(string $indexName, array $filters = []): array
    {
        $filter_query = [];

        // Aplicar os mesmos filtros da busca principal
        if (!empty($filters['type'])) {
            $filter_query[] = ['term' => ['type' => $filters['type']]];
        }
        if (!empty($filters['year'])) {
            $filter_query[] = ['term' => ['year' => $filters['year']]];
        }
        if (!empty($filters['institution'])) {
            $filter_query[] = ['match' => ['institution' => $filters['institution']]];
        }

        $params = [
            'index' => $indexName,
            'body' => [
                'size' => 0, // Não retorna documentos, apenas agregações
                'query' => [
                    'bool' => [
                        'filter' => $filter_query
                    ]
                ],
                'aggs' => [
                    'by_type' => [
                        'terms' => [
                            'field' => 'type',
                            'size' => 20
                        ]
                    ],
                    'by_year' => [
                        'terms' => [
                            'field' => 'year',
                            'size' => 20,
                            'order' => ['_key' => 'desc']
                        ]
                    ],
                    'by_institution' => [
                        'terms' => [
                            'field' => 'institution.keyword',
                            'size' => 10
                        ]
                    ],
                    'by_language' => [
                        'terms' => [
                            'field' => 'language',
                            'size' => 10
                        ]
                    ],
                    'by_areas' => [
                        'nested' => [
                            'path' => 'areas'
                        ],
                        'aggs' => [
                            'area_breakdown' => [
                                'terms' => [
                                    'field' => 'areas.grande_area',
                                    'size' => 10
                                ]
                            ]
                        ]
                    ],
                    'year_stats' => [
                        'stats' => [
                            'field' => 'year'
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        return $response->asArray();
    }

    public function getUniqueValues(string $indexName, string $field, int $size = 100): array
    {
        $params = [
            'index' => $indexName,
            'body' => [
                'size' => 0,
                'aggs' => [
                    'unique_values' => [
                        'terms' => [
                            'field' => $field,
                            'size' => $size
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        $result = $response->asArray();
        
        $values = [];
        if (isset($result['aggregations']['unique_values']['buckets'])) {
            foreach ($result['aggregations']['unique_values']['buckets'] as $bucket) {
                $values[] = $bucket['key'];
            }
        }
        
        return $values;
    }
}
