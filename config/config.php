<?php

return [
    'elasticsearch' => [
        'hosts' => [
            'http://localhost:9200' // Endereço do seu servidor Elasticsearch
        ]
    ],
    'data_paths' => [
        'lattes_xml' => __DIR__ . '/../data/lattes_xml'
    ],
    'app' => [
        'index_name' => 'prodmais_cientifica' // Nome do índice no Elasticsearch
    ]
];
