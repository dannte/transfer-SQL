<?php

namespace App\Controllers\Backend;

use Silex;
$frontend = $app['controllers_factory'];

/**
 * Show survey form
 */

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

$frontend->get('/', function() use($app) {
    $path = trim($app['request']->getPathInfo(), '/');

    if ($app['session']->get('is_authorized') == null && $path == '') {
       return $app['twig']->render('frontend/auto.html', array());
    } else {
        return $app['twig']->render('frontend/content.html', array('user_lod' => $app['session']->get('user_active')));
    }
});

$frontend->get('/login', function() use($app)
{
    echo 'hello';
});

/**
 * Save data in database
 */
$frontend->post('/connect_test', function() use($app) {
    $postData = $app['request']->request->all();

    if ($postData['i_db_name'] == '' && $postData['s_db_name'] == '') {
        $checkConnect = new \App\Models\CheckConnect($postData);
        $listDataBase = $checkConnect->getListDataBases();

        return !$listDataBase? json_encode(false): json_encode($listDataBase);
    } else {
        $postData['db_name'] = $postData['i_db_name'] == '' ? $postData['s_db_name'] : $postData['i_db_name'];

        $addDb  = new \App\Models\Report($app);
        $addDb->addNewConnect($postData);
    }

});

$frontend->post('/login', function() use($app)
{
    $post = $app['request']->request->all();

    if (empty($post)) {
        return $app->redirect('/');
    }

    $sql  = "SELECT * FROM active_users WHERE login = ? AND password = ?";
    $user = $app['db']->fetchAssoc($sql, array($post['user_login'], md5($post['user_pass'])));

    if (!$user) {
        return $app->redirect('/');
    }

    $app['session']->set('is_authorized', 1);
    $app['session']->set('user_active', $user['login']);

    return $app['twig']->render('frontend/content.html', array('user_lod' => $app['session']->get('user_active')));
});

$frontend->post('/reg', function() use($app)
{
    $arrRegistration = $app['request']->request->all();

    if (isset($arrRegistration) && !empty($arrRegistration)) {

        $pas = $arrRegistration['reg_pass'];
        $log = $arrRegistration['reg_login'];

        if (!empty($pas) && !empty($log)) {
            $app['db']->insert('active_users', array(
                'date'     => strtotime(date("Y-m-d H:i:s")),
                'login'    => $log,
                'password' => md5($pas)
            ));
        }

        if ($app['db']->lastInsertId()) {
            return $app->redirect('/');
        }
    }
});

/**
 * Logout
 */
$frontend->get('/logout', function() use($app) {
    $app['session']->set('is_authorized', null);
    $app['session']->set('user_active', '');
    return $app['twig']->render('frontend/auto.html', array());
});

return $frontend;