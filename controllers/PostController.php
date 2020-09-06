<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 21.03.2018
 * Time: 9:33
 */

namespace controllers;

use core\Validator;
use models\PostModel;
use core\DBconnector;
use core\DBDriver;

class PostController extends BaseController
{
    public function indexAction()
    {
        $this->title .= '::список постов';
        $mPost = new PostModel(new DBDriver(DBconnector::connect()), new Validator());
        $posts = $mPost->getAll();
        $this->content = $this->build(__DIR__ . '/../views/posts.php', ['posts' => $posts]);
    }

    public function readAction()
    {
        $id = $this->request->get('id');
        $this->title .= '::выбран пост №' . $id;
        $mPost = new PostModel(new DBDriver(DBconnector::connect()), new Validator());
        $post = $mPost->getById($id);
        $this->content = $this->build(__DIR__ . '/../views/post.php', ['post' => $post]);
    }

    public function addAction()
    {
        $this->title .= '::добавить пост';
        if ($this->request->isPost()) {
            $mPost = new PostModel(new DBDriver(DBconnector::connect()), new Validator());
            $insertID = $mPost->add([
                    'title' => $this->request->post('title'),
                    'content' => $this->request->post('content')
                ]
            );
            $this->redirect(('../posts/read/' . $insertID));
        }
        $this->content = 'Добавлена запись с ID=' . $insertID;
    }

    public function updateAction()
    {
        $this->title .= '::обновить информацию у поста';
        if ($this->request->isPost()) {
            $mPost = new PostModel(new DBDriver(DBconnector::connect()), new Validator());
            $mPost->update(
                [
                    'title' => $this->request->post('title'),
                    'content' => $this->request->post('content')
                ],
                [
                    'id' => $this->request->post('id')
                ]
            );
            $this->content = 'Спасибо, запись обновлена! ID=' . $this->request->post('id');
        }
    }
    public function deleteAction()
    {
        $this->title .= '::удалить информацию';
        if ($this->request->isPost()) {
            $mPost = new PostModel(new DBDriver(DBconnector::connect()), new Validator());
            $mPost->delete([
                'id' => $this->request->post('id')
            ]);
            $this->content = 'Спасибо, запись удалена! ID=' . $this->request->post('id');
        }
    }

}