<?php

namespace Prodmais\Elasticsearch;

use Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    private $client;
    private $indexName;

    public function __construct(array $config, string $indexName)
    {
        $this->client = ClientBuilder::create()->setHosts($config['hosts'])->build();
        $this->indexName = $indexName;
    }

    public function recreateIndex()
    {
        if ($this->client->indices()->exists(['index' => $this->indexName])) {
            $this->client->indices()->delete(['index' => $this->indexName]);
        }

        $this->client->indices()->create([
            'index' => $this->indexName,
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

    public function bulkIndex(array $documents)
    {
        $params = ['body' => []];

        foreach ($documents as $doc) {
            $params['body'][] = [
                'index' => [
                    '_index' => $this->indexName,
                    '_id'    => $doc['id']
                ]
            ];
            $params['body'][] = $doc;
        }

        $this->client->bulk($params);
    }

    public function search(array $filters = [], int $size = 50)
    {
        $query = [];

        if (!empty($filters['type'])) {
            $query[] = ['term' => ['type' => $filters['type']]];
        }
        if (!empty($filters['year'])) {
            $query[] = ['term' => ['year' => $filters['year']]];
        }
        if (!empty($filters['program'])) { // Supondo que o nome do programa esteja no nome do pesquisador
            $query[] = ['match' => ['researcher_name' => $filters['program']]];
        }

        $params = [
            'index' => $this->indexName,
            'body'  => [
                'size' => $size,
                'sort' => [
                    ['year' => ['order' => 'desc']]
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
