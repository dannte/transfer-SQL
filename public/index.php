<?php

ini_set('display_errors', 'On');
define('APP_ROOT_DIR', realpath(__DIR__ . '/../app/'));

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => APP_ROOT_DIR.'/views']);
$app->register(new Silex\Provider\SessionServiceProvider());

$app['debug'] = true;

$app->get('/', function () use ($app) {

    if ($app['session']->get('is_authorized') == null) {
        return $app->redirect('/login');
    }
    var_dump($_POST);
    return $app->redirect('/');
});

$app->mount('/', require APP_ROOT_DIR . '/controllers/frontend.php');
$app->run();