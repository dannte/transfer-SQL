<?php

ini_set('display_errors', 'On');

define('ROOT_DIR', realpath(__DIR__ . '/../'));
define('APP_ROOT_DIR', realpath(__DIR__ . '/../app/'));

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * PSR-0 compatible autoloader
 */
spl_autoload_register(function($class) {

    $class = explode('\\', $class);
    if ($class[0] != 'Symfony') {
        $file  = array_pop($class);
        $class = ROOT_DIR . '/' . strtolower(implode('/', $class)) . '/' . $file . '.php';

        require_once $class;
    }
});

$app = new Silex\Application();
$app['etc'] = require_once APP_ROOT_DIR . '/etc/config.php';

$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => APP_ROOT_DIR.'/views']);
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'transfer-dev' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'transfer-dev',
            'user'      => 'root',
            'password'  => 'shumaxer86',
            'charset'   => 'utf8',
        )
)));
$app->register(new Silex\Provider\SessionServiceProvider());

$app['debug'] = true;

$app->get('/', function () use ($app) {

    if ($app['session']->get('is_authorized') == null) {
        return $app->redirect('/login');
    }

    return $app->redirect('/');
});

$app->mount('/', require APP_ROOT_DIR . '/controllers/frontend.php');
$app->run();