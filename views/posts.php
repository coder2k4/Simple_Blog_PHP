<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 21.03.2018
 * Time: 9:00
 */

//<!--
//Вьешка для ссылок на все посты
//-->
// Генерируем ссылки из полученного массива с постами, подставляем $id , $title.
// Ссылка вида ЧПУ используется.
foreach ($posts as $post): ?>

    <div class="postWrap">
        <h3>
            <a href="/posts/read/<?=$post['id']?>"><?=$post['title']?></a>
        </h3>
    </div>

<? endforeach; ?>
