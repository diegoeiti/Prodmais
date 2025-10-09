<?php

namespace App;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    private $client;

    public function __construct(array $esConfig)
    {
        $this->client = ClientBuilder::create()
            ->setHosts($esConfig['hosts'])
            ->setRetries(3)
            ->build();
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
        $must_query = [];
        $filter_query = [];

        // A busca por texto vai na cláusula principal
        if (!empty($filters['q'])) {
            $must_query[] = [
                'multi_match' => [
                    'query' => $filters['q'],
                    'fields' => ['title', 'researcher_name']
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
        if (!empty($filters['year'])) {
            $filter_query[] = ['term' => ['year' => $filters['year']]];
        }
        if (!empty($filters['program'])) {
            $filter_query[] = ['match' => ['researcher_name' => $filters['program']]];
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
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
