<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Database connection
$container['db'] = function ($c) {
    try {
        $settings = $c->get('settings')['db'];
        $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";port=" . $settings['port'] . ";charset=" . $settings['charset'],
            $settings['user'], $settings['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        return 'Connection failed: ' . $e->getMessage();
    }
   
};



//Task
$container['App\Action\TaskAction'] = function ($c) {
    $taskResource = new \App\Resource\TaskResource($c->get('db'));
    return new App\Action\TaskAction($taskResource);
};

//Categories
$container['App\Action\CategoryAction'] = function ($c) {
    $categoryResource = new \App\Resource\CategoryResource($c->get('db'));
    return new App\Action\CategoryAction($categoryResource);
};