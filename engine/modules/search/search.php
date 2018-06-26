<?php

namespace engine;

define('READFILE', true);

include_once '/home/ubuntu/workspace/engine/db.php';
include_once '/home/ubuntu/workspace/engine/config.php';
include_once '/home/ubuntu/workspace/engine/filter.php';

if (!empty($_POST['referal'])) { //Принимаем данные
        $referal = strip_data(trim(strip_tags(stripcslashes(htmlspecialchars($_POST['referal'])))));

    $db_referal = $db->query("SELECT id, tags, upper(title), problem from posts WHERE tags LIKE '%$referal%' OR title LIKE '%$referal%' ORDER BY date DESC LIMIT 0,5")
        or die('Ошибка №'.__LINE__.'<br>Пожалуйста, обратитесь к администратору сайта, сообщив номер ошибки.');

        /*while ($row = $db_referal -> fetch_array()) {
            echo "\n<li><div class=postid style='display:none'>".$row["id"]."</div>".$row["title"]."</li>"; //$row["name"] - имя поля таблицы
        }*/
        for ($i = 0; $i <= mysqli_num_rows($db_referal) - 1; ++$i) {
            $myrow = mysqli_fetch_array($db_referal);

            echo "\n<li><div class=postid style='display:none'>".$myrow['id'].'</div>'.$myrow['title'].'('.rtrim(substr($myrow['problem'], 0, 100), '!,.-').'...'.')</li>';
        }
}
