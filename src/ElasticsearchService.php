<?php

namespace App;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    private $client;

    public function __construct(array $esConfig)
    {
        $this->client = ClientBuilder::create()->setHosts($esConfig['hosts'])->build();
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
                        'title' => ['type' => 'text', 'analyzer' => 'portuguese'],
                        'year' => ['type' => 'integer'],
                        'type' => ['type' => 'keyword'],
                        'doi' => ['type' => 'keyword'],
                        'source' => ['type' => 'keyword']
                    ]
                ]
            ]
        ]);
    }

    public function bulkIndex(string $indexName, array $documents): void
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

        if (!empty($params['body'])) {
            $this->client->bulk($params);
        }
    }

    public function search(string $indexName, array $filters = [], int $size = 50)
    {
        $query = [];

        if (!empty($filters['type'])) {
            $query[] = ['term' => ['type' => $filters['type']]];
        }
        if (!empty($filters['year'])) {
            $query[] = ['term' => ['year' => $filters['year']]];
        }
        if (!empty($filters['program'])) { 
            $query[] = ['match' => ['researcher_name' => $filters['program']]];
        }
        if (!empty($filters['q'])) {
            $query[] = [
                'multi_match' => [
                    'query' => $filters['q'],
                    'fields' => ['title', 'researcher_name']
                ]
            ];
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
                        'must' => empty($query) ? ['match_all' => new \stdClass()] : $query
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
