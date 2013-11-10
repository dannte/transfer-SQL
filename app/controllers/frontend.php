<?php

namespace App\Controllers\Backend;


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

return $frontend;