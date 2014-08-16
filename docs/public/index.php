<?php

date_default_timezone_set('Europe/Belgrade');
define('BASE_DIR', dirname(__FILE__));

require BASE_DIR . '/../vendor/autoload.php';
require BASE_DIR . '/../lib/LoggerMiddleware.php';

$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig(),
    'mode' => 'development',
    'templates.path' => BASE_DIR . '/../templates',
    'log.enabled' => true,
));
$view = $app->view();
// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app, $view) {
    $app->config(array(
        'debug' => false,
    ));
    $view->parserOptions = array(
        'debug' => false,
        'cache' => realpath(BASE_DIR . '/../twig_cache'),
        'auto_reload' => false,
        'strict_variables' => false,
        'autoescape' => true,
        'optimizations' => -1,
    );
});
// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app, $view) {
    $app->config(array(
        'debug' => true,
    ));
    $view->parserOptions = array(
        'debug' => true,
        'cache' => realpath(BASE_DIR . '/../twig_cache'),
        'auto_reload' => true,
        'strict_variables' => true,
        'autoescape' => true,
        'optimizations' => -1,
    );
});
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);
// logger middleware
$app->add(new \LoggerMiddleware());


$app->get('/', function () use ($app) {
    $app->render('proba.twig', array('a_variable' => 'Pega', 'navigation' => array(array('href' => 'http://www.google.com/', 'caption' => 'google'))));
});

$app->run();