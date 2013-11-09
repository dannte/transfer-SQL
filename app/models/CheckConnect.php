<?php

namespace App\Models;

class CheckConnect
{
    protected $host = '';

    protected $user = '';

    protected $pass = '';

    protected $db   = '';

    function __construct($host, $user, $pass, $db) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db   = $db;
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