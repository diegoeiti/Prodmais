<?php

return [
    'elasticsearch' => [
        'hosts' => [
            'http://localhost:9200' // Endereço do seu servidor Elasticsearch
        ]
    ],
    'data_paths' => [
        'lattes_xml' => __DIR__ . '/../data/lattes_xml',
        'logs' => __DIR__ . '/../data/logs.sqlite',
        'uploads' => __DIR__ . '/../data/uploads'
    ],
    'app' => [
        'index_name' => 'prodmais_cientifica', // Nome do índice no Elasticsearch
        'version' => '1.0.0'
    ]
];
