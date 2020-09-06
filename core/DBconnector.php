<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 20.03.2018
 * Time: 12:12
 */

namespace core;

class DBconnector
{
    private static $db;

    public static function connect()
    {
        $dbtype = 'mysql';
        $dbname = 'PHP_2';
        $dbhost = 'localhost';
        $dblogin = 'root';
        $dbpass = '';
        $dsn = sprintf("%s:host=%s;dbname=%s", $dbtype, $dbhost, $dbname);


        if (self::$db === null) {
            try {
                self::$db = new \PDO($dsn, $dblogin, $dbpass);
                self::$db->exec('SET NAMES UTF8'); //Установка кодировки (перестраховка)
                return self::$db;
            } catch (\PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                return NULL;
            }
        }
        return self::$db;
    }
}