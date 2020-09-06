<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 21.03.2018
 * Time: 9:22
 */

namespace controllers;

use core\Request;

class BaseController
{
    protected $title;
    protected $content;
    protected $request; //Объект класса Request

    public function __construct(Request $request)
    {
        $this->title = 'PHP 2';
        $this->content = '';
        $this->request = $request;
    }

    public function render()
    {
        echo $this->build(
            __DIR__ . "/../views/main.php",
            [
                'title' => $this->title,
                'content' => $this->content
            ]
        );
    }

    protected function redirect($uri)
    {
//      todo сделать проверку, что $uri- это юри
//      todo Добавить редирект 403
       // var_dump(sprintf('Location: %s',$uri));
        header(sprintf('Location: %s',$uri));
        die();
    }

    protected function build($templateName, array $params = [])
    {
        extract($params);
        ob_start();
        include_once($templateName);
        return ob_get_clean();
    }
}