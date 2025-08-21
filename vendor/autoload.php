<?php

spl_autoload_register(function ($class) {
    $prefix = 'Elasticsearch\\';
    $base_dir = __DIR__ . "/elasticsearch/elasticsearch/src/";

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Adicionar manualmente outros autoloaders necessários, como o de PSR
require_once __DIR__ . '/psr/log/src/LoggerInterface.php';
require_once __DIR__ . '/psr/http-message/src/RequestInterface.php';
require_once __DIR__ . '/psr/http-message/src/ResponseInterface.php';
require_once __DIR__ . '/psr/http-message/src/StreamInterface.php';
require_once __DIR__ . '/psr/http-client/src/ClientInterface.php';

// E o autoloader do GuzzleHttp, um cliente HTTP que o Elasticsearch usa
spl_autoload_register(function ($class) {
    $prefix = 'GuzzleHttp\\';
    $base_dir = __DIR__ . '/guzzlehttp/guzzle/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'GuzzleHttp\\Psr7\\';
    $base_dir = __DIR__ . '/guzzlehttp/psr7/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'GuzzleHttp\\Promise\\';
    $base_dir = __DIR__ . '/guzzlehttp/promises/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require_once __DIR__ . '/elasticsearch/elasticsearch/src/ClientBuilder.php';
