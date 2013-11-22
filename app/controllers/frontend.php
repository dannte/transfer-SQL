<?php

namespace App\Controllers\Backend;

use Silex;
$frontend = $app['controllers_factory'];

/**
 * Show survey form
 */

$frontend->get('/', function() use($app) {
    $path = trim($app['request']->getPathInfo(), '/');

    if ($app['session']->get('is_authorized') == null && $path == '') {
       return $app['twig']->render('frontend/auto.html', array());
    } else {
        return $app['twig']->render('frontend/content.html', array());
    }
});

$app->get('index.php/login', function() use($app)
{
    echo 'Test';
    die();
});

/**
 * Save data in database
 */
$frontend->post('/', function() use($app) {
    $postData = $app['request']->request->all();

    if ($postData['i_db_name'] == '' && $postData['s_db_name'] == '') {
        $checkConnect = new \App\Models\CheckConnect($postData['connect_host'],$postData['connect_user'],$postData['connect_password']);
        $listDataBase = $checkConnect->getListDataBases();

        if (!$listDataBase) {
            return json_encode(false);
        } else {
            return json_encode($listDataBase);
        }
    } else {
        $postData['db_name'] = $postData['i_db_name'] == '' ? $postData['s_db_name'] : $postData['i_db_name'];

        $addDb  = new \App\Models\Report($app);
        $addDb->addNewConnect($postData);
    }

});

$app->post('/login', function() use($app)
{
   var_dump($app['request']->request->all());
    exit();
});

$app->post('/reg', function() use($app)
{
    $arrRegistration = $app['request']->request->all();

    if (isset($arrRegistration) && !empty($arrRegistration)) {

        $pas = $arrRegistration['reg_pass'];
        $log = $arrRegistration['reg_login'];

        if (!empty($pas) && !empty($log)) {
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
                )
            ));

            $app['db']->insert('active_users', array(
                'date'     => strtotime(date("Y-m-d H:i:s")),
                'login'    => $log,
                'password' => md5($pas)
            ));
        }

        var_dump($app['request']->query->get('id'));

    }
});
return $frontend;