<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 20.03.2018
 * Time: 10:59
 */


// Опеределяем пространства имен для классов, где первое слово - пространство, воторое имя класса
// Сделано через \ и имя пространства = папке с классом для автозагрузки класса.
use core\DBconnector;
//use core\Templater;
use models\UserModel;
use models\PostModel;


session_start();

try {
// Функция для автозагрузки классов, более новая и безопасная - spl_autoload_register
    function __autoload($className)
    {
//    Универсальный код для дирректории из под Windows и *Nix систем
        $filePatch = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
//    Если файл существует, добавим его, если нет, сделаем var_dump
        if (file_exists($filePatch))
            include_once($filePatch);
        else
            var_dump($filePatch);
    }

    $uri = $_SERVER['REQUEST_URI']; //Хранит в себе путь
    $uriParts = explode('/', $uri); //Разбиваем путь по / на массив параметров
    unset($uriParts[0]); // Удаляем первый элемент массива, который всегда равен 0
    $uriParts = array_values($uriParts); // Перезаписываем массив (переопределяем ключи)


//Получаем и склеиваем контролле из строки состояния.
    $controller = isset($uriParts[0]) && $uriParts[0] !== '' ? $uriParts[0] : 'posts';

    switch ($controller) {
        case 'posts':
            $controller = 'Post';
            break;
        case 'user':
            $controller = 'User';
            break;
        default:
            throw new \core\Exception\ModelException();
            header("HTTP/1.0 404 Not Found"); //Отправляет для роботов заголовок ERROR 404
            die('Error 404');

    }


//Делаем "экшн" по 2му ключу в URL.
    if (isset($uriParts[1]) && $uriParts[1] != '' && !is_numeric($uriParts[1]))
        $action = sprintf('%sAction', $uriParts[1]);
    else
        $action = sprintf('%sAction', 'Index');


//Получаем ID
    if (isset($uriParts[2]) && $uriParts[2] != '' && is_numeric($uriParts[2])) {
        $id = $uriParts[2];
        $_GET['id'] = $id;
    } else
        $id = null;

    $request = new \core\Request($_GET, $_POST, $_SERVER, $_COOKIE, $_SESSION, $_FILES);
    $controller = sprintf('\controllers\%sController', $controller);
    $controller = new $controller($request);


    if ($id) //Если у нас есть параметр ID, пытаемся передаеть его в ACTION
        $controller->$action();
    else
        $controller->$action();
    $controller->render();

    echo $baseTemplate;
}
catch (Exception $e){
    echo 'ERROR 404';
}


