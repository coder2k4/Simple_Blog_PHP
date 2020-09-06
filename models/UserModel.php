<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 20.03.2018
 * Time: 16:15
 */

namespace models;

class UserModel extends BaseModel
{
    public function __construct(\PDO $db)
    {
        parent::__construct($db,'users');
    }

    public function addUser($login, $password)
    {
        $sql = sprintf("INSERT INTO %s(login,password) VALUES (:login,:password)", $this->table);
        $query = $this->mySqlQuery($sql, ['login' => $login, 'password' => $password]);
        return ($query ? true : false);
    }

    public function updateUser($id, $login, $password)
    {
        $sql = sprintf("UPDATE %s SET (login=:login,password=:password) WHERE id=:id", $this->table);
        $query = $this->mySqlQuery($sql, ['id' => $id, 'login' => $login, 'password' => $password]);
        return ($query ? true : false);
    }
}


