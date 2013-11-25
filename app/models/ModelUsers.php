<?php


namespace App\Models;

use Silex;

class ModelUsers {

    protected $app = null;

    protected $table = 'active_users';

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function addNewUsers($log, $pas)
    {
        $this->app['db']->insert($this->table, array
        (
           'date'     => strtotime(date("Y-m-d H:i:s")),
           'login'    => $log,
           'password' => md5($pas)
        ));

        if ($this->app['db']->lastInsertId()) {
            return $this->app->redirect('/');
        } else {
            return false;
        }
    }

    public function getUserByNamePass($login, $pass)
    {
        $sql  = "SELECT * FROM {$this->table} WHERE login = ? AND password = ?";
        $user = $this->app['db']->fetchAssoc($sql, array($login, md5($pass)));

        return !$user ? false : $user;
    }

    public function deleteOutUser($id)
    {
        return $this->app['db']->delete($this->table, array(
            'id' => $id
        ));
}
} 