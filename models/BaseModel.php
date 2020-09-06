<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 20.03.2018
 * Time: 15:51
 */

namespace models;

use core\DBDriver;
use core\Validator;

class BaseModel
{
    private $db;
    protected $table;
    protected $validator;

    public function __construct(DBDriver $db, Validator $validator, $table)
    {
        $this->db = $db;
        $this->table = $table;
        $this->validator = $validator;
    }

    public function getAll()
    {
        $sql = sprintf("SELECT * FROM %s", $this->table);
        return $this->db->select($sql);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        return $this->db->select($sql, ['id' => $id], DBDriver::FETCH_ONE);
    }

    public function add(array $params)
    {
        $this->validator->execute();
        if(!$this->validator->success){
            //Ошибка, обработать с помощью исключений
            $this->validator->errors;
        }


        return $this->db->insert($this->table, $params);
    }

    public function update(array $patams, array $where)
    {
        return $this->db->update($this->table, $patams, $where);
    }

    public function delete(array $where)
    {
        return $this->db->delete($this->table, $where);
    }

    public function validate()
    {
        $this->validator->execute();
    }

}