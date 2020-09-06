<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 23.03.2018
 * Time: 9:19
 */

namespace core;

// Класс для работы с глобальными массивами ^_^ чуть позже напишем еще хаки.
class Request
{
//
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    public $get = '';
    public $post = '';
    public $server = '';
    public $cookie = '';
    public $session = '';
    public $files = '';

    public function __construct($get, $post, $server, $cookie, $session, $files)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
        $this->cookie = $cookie;
        $this->session = $session;
        $this->files = $files;
    }

    public function get($key = null)
    {
        return $this->getArray($this->get,$key);
    }

    public function post($key = null)
    {
        return $this->getArray($this->post,$key);
    }



    public function isPost()
    {
        if ($this->server['REQUEST_METHOD'] === self::METHOD_POST)
            return true;
        return false;
    }

    public function isGet()
    {
        if ($this->server['REQUEST_METHOD'] === self::METHOD_GET)
            return true;
        return false;
    }

    private function getArray(array $arr, $key)
    {
        if (isset($arr[$key]))
            return $arr[$key];
        if (!$key) {
            return $arr;
        }
        return null;
    }
}