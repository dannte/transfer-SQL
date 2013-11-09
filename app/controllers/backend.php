<?php

namespace App\Controllers\Backend;


$backend = $app['controllers_factory'];


/** 
 * Homepage
 */
$backend->get('/', function() use($app) {
  if ($app['session']->get('is_authorized')) {
    return $app->redirect('/stat/survey');
  }

  return $app['twig']->render('backend/auth.html', ['message' => null]);
});

/**
 * Authorization
 */
$backend->post('/', function() use($app) {

  if ($app['session']->get('is_authorized')) {
    return $app->redirect('/stat/survey');
  }

  $key = $app['request']->get('auth_key');

  if (sha1($key) === $app['etc']['auth_key']) {
    $app['session']->set('is_authorized', 1);
    return $app->redirect('/stat/survey');
  }

  return $app['twig']->render('backend/auth.html', ['message' => 'Wrong Authorization Key!']);
});


/**
 * Logout
 */
$backend->get('/logout', function() use($app) {
  $app['session']->set('is_authorized', null);
  return $app->redirect('/stat');
});


/**
 * Report View
 */
$backend->get('/survey', function() use($app, $alert) {

  if ($app['session']->get('is_authorized') === null) {
     return $app->redirect('/stat');
  }
  $countColumns = 3;
  $reportBuilder = new \App\Models\Report($app);
  $report = $reportBuilder->buildReport();

  $allCustomizedReport = $reportBuilder->getListOfFields();

  $customizedReport = $allCustomizedReport[0];
  $personalReport   = $allCustomizedReport[1];
  $count            = count($customizedReport);
  $columns          = ceil($count/$countColumns);
  $model            = new \App\Models\Survey($app);
  $countItems       = count($model->filter());

  return $app['twig']->render('backend/report.html', array
  (
      'report'            => $report,
      'customized_report' => $customizedReport,
      'columns'           => $columns,
      'countitems'        => $countItems,
      'personal_report'   => $personalReport
  ));
});


/**
 * Download data as XLS file
 */
$backend->get('/xls', function() use($app, $alert) {

   $reportBuilder = new \App\Models\Report($app);
   $report = $reportBuilder->buildReport();
   $model            = new \App\Models\Survey($app);
   $countItems        = count($model->filter());

   header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
   header('Content-Disposition: attachment; filename="report.xls"');

   return $app['twig']->render('backend/report-xls.html', array('report' => $report, 'countitems' => $countItems));
});

/**
 * customized_report
**/
$backend->post('/customized_report', function() use($app, $alert) {
    $model       = new \App\Models\Survey($app);
    $collections = $model->getCollection($_POST);
    $report      = new \App\Models\Report($app);
    $keys        = $report->getListOfFields();

    $table       = $model->getTable($collections, $keys);

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header('Content-Disposition: attachment; filename="data.xls"');

    return $app['twig']->render('backend/data-xsl.html', array('report' => $table));
    //exit;

});


/**
 * personal_report
 **/
$backend->post('/personal_report', function() use($app, $alert) {
    $model       = new \App\Models\Survey($app);
    $collections = $model->getCollection($_POST);
    $report      = new \App\Models\Report($app);
    $keys        = $report->getListOfFields();
    $table       = $model->getTable($collections, $keys, 1);

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header('Content-Disposition: attachment; filename="data.xls"');

    return $app['twig']->render('backend/data-xsl.html', array('report' => $table));
    //exit;

});

return $backend;
