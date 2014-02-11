<?php

namespace App\Models;

use Silex;

class ModelTables {

    const  PREFIX_TABLE = 'Tables_in_';

    protected $app = null;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function addNewConnect($arrData)
    {
        $data = $this->builderDBSettings($arrData);

        if (!$data) {
            return false;
        }

        $this->app->register(new Silex\Provider\DoctrineServiceProvider(), array(
            'dbs.options' => $data
        ));

        $arrTables = $this->getListTable(key($data));

        return  count($arrData) > 0 ? $arrTables : false;
    }

    protected function builderDBSettings($data)
    {
        if (empty($data)) {
            return false;
        }

        $arr  = array
        (
            $data['db_name'] => array
            (
                'driver'   => 'pdo_mysql',
                'host'     => $data['connect_host'],
                'dbname'   => $data['db_name'],
                'user'     => $data['connect_user'],
                'password' => $data['connect_password'],
                'charset'  => 'utf8'
            )
        );

        return $arr;
    }

    protected function getListTable($db_name)
    {
        if ($db_name == '') {
            return null;
        }

        $dbr = $this->app['db']->query("SHOW TABLES");

        $arrResult = array();

        if ($dbr) {
            $dbr = $dbr->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($dbr as $table) {
                $arrResult[] = $table[self::PREFIX_TABLE . $db_name];
            }
        }

        return  $arrResult;
    }
} 