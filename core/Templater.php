<?php
///**
// * Created by PhpStorm.
// * User: elvis
// * Date: 21.03.2018
// * Time: 8:22
// */
//
//namespace core;
//
//
///**
// * Class Templater - Статичный класс для дампа из буфера информации и подстановки заданных параметров
// * @package core
// * @function build - для создания слепка блока вьюшки
// */
//class Templater
//{
//    public static function build($templateName, array $params = [])
//    {
//        extract($params);
//        ob_start();
//        include ($templateName);
//        return ob_get_clean();
//    }
//}