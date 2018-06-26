<?php

$result = '';
$title = strip_data($_POST['title']);
$tags = strip_data($_POST['tags']);
$problem = $_POST['problem'];
$solution = $_POST['solution'];
$template->set('[content]', $template->out('templates/'.$template_name.'/editor.tpl'));
$template->set('[posttitle]', '');
$template->set('[tags]', '');
$template->set('[problem]', '');
$template->set('[solution]', '');

if (isset($_SESSION['hash'])) {
    if (isset($_POST) and $_POST['title'] != null) {
        if ($title != null and $tags != null and $problem != null and $solution != null) {
            if (strlen($title) > 5 and strlen($tags) > 5 and strlen($problem) > 20 and strlen($solution) > 20) {
                $author = mysqli_fetch_array($db->query("SELECT username,id FROM users WHERE hash = '".$_SESSION['hash']."'"));
                $date = date('Y-m-d H:i');
                $problem = mysqli_real_escape_string($db->linkD, $problem);
                $solution = mysqli_real_escape_string($db->linkD, $solution);
                $hash = md5(generateCode(10));

                $add_req = $db->query("INSERT INTO posts(title, tags, problem, solution,author,date,hash) VALUES('$title','$tags', '$problem', '$solution','".$author['username']."','$date','$hash')");
                $id = mysqli_fetch_array($db->query("SELECT id FROM posts WHERE hash = '".$hash."'"));
                $id = $id['id'];
                setcookie($id, $hash, time() + (60 * 60 * 24));
                $_COOKIE[$id] = $hash;
                header('Location: /');
                exit;
            } else {
                $result = 'Слишком мало информации в посте!';
            }
        } else {
            $result = 'Вы заполнили не все поля!';
        }
    }
}
$template->set('[result]', $result);

$template->set('[title]', 'Создание/редактирование поста');
