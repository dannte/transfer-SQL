<?php 

namespace App\Etc;

$RD = ROOT_DIR;

/**
 * Development configuration
 */
$localConfig = [
  'auth_key' => '631b792ec8855b6056a209fc1252252c06f9e326', // 520xCVcV7V3n3RCn
  'database' => array (
      'transfer-dev' => array(
          'driver'    => 'pdo_mysql',
          'host'      => 'localhost',
          'dbname'    => 'transfer-dev',
          'user'      => 'root',
          'password'  => 'shumaxer86',
          'charset'   => 'utf8',
      )
    ),
];

/**
 * Production configuration
 */
$serverConfig = [
    'auth_key' => '631b792ec8855b6056a209fc1252252c06f9e326', // 520xCVcV7V3n3RCn
    'database' => array (
        'transfer-dev' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'transfer-dev',
            'user'      => 'root',
            'password'  => 'shumaxer86',
            'charset'   => 'utf8',
        )
    ),
];

if (isset($_SERVER['HTTP_X_REAL_IP']) && $_SERVER['HTTP_X_REAL_IP'] != '127.0.0.1') {
  return $serverConfig;
}

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
  return $localConfig;
}

return $serverConfig;
