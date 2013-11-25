<?php

namespace App\Controllers\Backend;

use Silex;
$frontend    = $app['controllers_factory'];
$app['user'] = new \App\Models\ModelUsers($app);

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


$frontend->post('/connect_test', function() use($app) {
    $postData = $app['request']->request->all();

    if ($postData['i_db_name'] == '' && $postData['s_db_name'] == '') {
        $checkConnect = new \App\Models\CheckConnect($postData);
        $listDataBase = $checkConnect->getListDataBases();

        return !$listDataBase ? json_encode(false): json_encode($listDataBase);
    } else {
        $postData['db_name'] = $postData['i_db_name'] == '' ? $postData['s_db_name'] : $postData['i_db_name'];

        $addDb  = new \App\Models\ModelTables($app);
        $tables = $addDb->addNewConnect($postData);

        return !$tables ? json_encode(false): json_encode($tables);
    }

});

$frontend->post('/login', function() use($app)
{
    $post = $app['request']->request->all();

    if (empty($post)) {
        return $app->redirect('/');
    }

    $login = $app['user']->getUserByNamePass($post['user_login'], $post['user_pass']);

    if (!$login) {
        return $app->redirect('/');
    }

    $app['session']->set('is_authorized', 1);
    $app['session']->set('user_active', $login['login']);
    $app['session']->set('user_id', $login['id']);

    return $app['twig']->render('frontend/content.html', array('user_lod' => $app['session']->get('user_active')));
});

$frontend->post('/reg', function() use($app)
{
    $arrRegistration = $app['request']->request->all();

    if (isset($arrRegistration) && !empty($arrRegistration)) {

        $pas = $arrRegistration['reg_pass'];
        $log = $arrRegistration['reg_login'];

        if ($app['user']->addNewUsers($log, $pas)) {
            return $app->redirect('/');
        } else {
            return $app['twig']->render('frontend/auto.html', array('error_add_user' => 'Error')); // TODO :: add text error
        }
    }
});

/**
 * Logout
 */
$frontend->get('/logout', function() use($app) {
    $delete = $app['user']->deleteOutUser($app['session']->get('user_id'));

    if (!$delete) {
        return $app['twig']->render('frontend/content.html', array('error_add_user' => 'Error')); // TODO :: add text error
    }

    $app['session']->set('is_authorized', null);
    $app['session']->set('user_active', '');
    $app['session']->set('user_id', '');

    return $app['twig']->render('frontend/auto.html', array());
});

return $frontend;