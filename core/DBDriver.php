<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 24.03.2018
 * Time: 17:17
 */

namespace core;


class DBDriver
{
    const FETCH_ALL = 'fetchAll';
    const FETCH_ONE = 'fetch';

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function select($sql, array $params = [], $fetch = self::FETCH_ALL)
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);

        //Попробовал хитрую систему, передает в переменную $fetch название метода и вызываем его
        // из свзяки $query->$fetch() - получаем $query->fetchALL() на выходе
        if ($fetch === self::FETCH_ALL || $fetch === self::FETCH_ONE)
            return $query->$fetch();
        else
            //Ерророчка конечно не та, ну пусть будет
            return null;
    }

    //Добавление строки в базу
    public function insert($table, array $params)
    {
        $colums = sprintf("%s", implode(", ", array_keys($params))); //Получаем title, content
        $mask = sprintf(":%s", implode(", :", array_keys($params))); //Получаем :title, :content


        $sql = sprintf("INSERT INTO %s(%s) VALUES(%s)", $table, $colums, $mask);
        $query = $this->pdo->prepare($sql);
        $query->execute($params);

        return $this->pdo->lastInsertId();
    }


    public function update($table, array $params, $where)
    {
        //UPDATE `articles` SET `title`=123,`content`=321 WHERE id = 3
        //title=:title,content=:content
        $colums = '';
        $whr = '';
        foreach (array_keys($params) as $args)
            $colums .= "$args=:$args, ";
        $colums = rtrim($colums, ', ');
        foreach (array_keys($where) as $args)
            $whr .= "$args=:$args, ";

        //Более красиво и элегантное решение :
        /*
        $result = implode(',', array_map(function($v){
                return "$v = :$v";
            },
                array_keys($params))
        );
        */

        $colums = rtrim($colums, ', ');
        $whr = rtrim($whr, ', ');
        //Сливаем масивы, для передачи общего в PDO params

        $params = array_merge($params, $where);
        $sql = sprintf("UPDATE %s SET %s WHERE %s", $table, $colums, $whr);
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        //UPDATE %s SET (title=:title,content=:content) WHERE id=:id
    }

    public function delete($table, $where)
    {
        $whr = '';
        foreach (array_keys($where) as $args)
            $whr .= "$args=:$args, ";
        $whr = rtrim($whr, ', ');

        //DELETE FROM `articles` WHERE 0
        $sql = sprintf("DELETE FROM %s WHERE %s", $table, $whr);
        $query = $this->pdo->prepare($sql);
        $query->execute($where);
    }
}