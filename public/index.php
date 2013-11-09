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
  $file  = array_pop($class);
  $class = ROOT_DIR . '/' . strtolower(implode('/', $class)) . '/' . $file . '.php';

  require_once $class;
});

$app = new Silex\Application();


// TODO: Debug mode
$app['debug'] = false;

// Loading array with settings
$app['etc'] = require_once APP_ROOT_DIR . '/etc/config.php';


// Registering Silex services
$app->register(new Silex\Provider\TwigServiceProvider(), ['twig.path' => APP_ROOT_DIR.'/views']);
$app->register(new Silex\Provider\DoctrineServiceProvider(), array('db.options' => $app['etc']['database']));
//var_dump($connect = new Silex\Provider\DoctrineServiceProvider(), array('db.options' => $app['etc']['database']));
$app->register(new Silex\Provider\SessionServiceProvider());

/**
 * Actions that will be running before controller
 */
$app->before(function() use($app) {
  // Simple Authorization
   $path = trim($app['request']->getPathInfo(), '/');

   if ($app['session']->get('is_authorized') == null && $path == '') {
       //$app->mount('/', require APP_ROOT_DIR . '/controllers/frontend.php');
       //return $app->redirect('/');

   }

  $flash = $app['session' ]->get('flash');
  $app['session']->set('flash', null);

  if (!empty($flash)) {
    $app['twig']->addGlobal('flash', $flash);
  }
});


/**
 * Shortcut for set flash alert messages
 */
$alert = function ($message, $title = '', $type = 'info')
  use($app)
{
  if (empty($title)) {
    $title = strtoupper($type);
  }

  $app['session']->set('flash', ['type' => $type, 'short' => $title, 'ext' => $message]);
};

/**
 * Mount Controllers
 */
$app->mount('/', require APP_ROOT_DIR . '/controllers/frontend.php');
$app->mount('/stat', require APP_ROOT_DIR . '/controllers/backend.php');

$app->run();
