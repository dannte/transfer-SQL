<?php

namespace App\Models;

class CheckConnect
{
    protected $host = '';

    protected $user = '';

    protected $pass = '';

    function __construct($arrData) {
        $this->host = $arrData['connect_host'];
        $this->user = $arrData['connect_user'];
        $this->pass = $arrData['connect_password'];
    }

    public function getListDataBases() {
        $conn = mysql_connect($this->host, $this->user, $this->pass) ;
        
        if (!$conn) {
            return false;
        }
        
        $result = @mysql_query('SHOW DATABASES'); 
        $arrDb  = array();

        while ($row = mysql_fetch_array($result)) { 
            $arrDb[] = $row['Database'];
        }

        mysql_close();

        return $arrDb;
    }

    public function getDataBase() {

    }
}