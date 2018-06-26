<?php

define('READFILE', true);
foreach (scandir('engine/modules/') as $key => $value) {
    $path = "engine/modules/$value/init.php";

    if (file_exists($path)) {
        require_once $path;
    }
}
include_once 'engine/template.php';
include_once 'engine/config.php';
include_once 'engine/db.php';
include_once 'engine/filter.php';
include_once 'engine/post.php';

require_once 'engine/lang.php';

session_start();
//$array = mysql_fetch_assoc($query);
// if(strcmp(md5($new_pass,$array['password']) == 0)

$secret = '6LdFBl8UAAAAAP2efwNBt5MLD4XyUjFNvy2J9WoX';
$page = strip_data($_GET['p']);
$query = strip_data($_GET['q']);
$activation = strip_data($_GET['activation']);

$template_name = $config->template_name;
$posts_on_page = $config->posts_on_page;
$sault = $config->sault;

$site_name = $config->site_name;

$host = $config->host;
$user = $config->user;
$password = $config->password;
$database = $config->database;

$subject = $config->subject;
$body = $config->body;
$body_lost_p = $config->body_lost_p;

$lang = $lang->getArray('ru-RU.json');

session_set_cookie_params(60 * 60 * 24 * 15);

/* Функция генератора рандомного кода для создания уникального хэша */
function generateCode($length = 6)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789';

    $code = '';

    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }

    return $code;
}
/* Проверка активации аккаунта */
if (isset($activation)) {
    $act = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT activation FROM users WHERE activation = '$activation')"));

    if ($act[0] > 0) {
        $perms = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT permissions FROM users WHERE activation = '$activation' AND permissions=0)"));
        if ($perms[0] > 0) {
            $act = $db->query("UPDATE `users` SET `permissions` = 1 WHERE `activation` = '$activation'");
            if ($act) {
                echo '<center>Активация пройдена</center>';
            }
        }
    }
}

/* Проверка сессии пользователя и ее подлинности */
if (isset($_SESSION['id']) and isset($_SESSION['hash'])) {
    $arr = mysqli_fetch_array($db->query("SELECT hash, username FROM users WHERE id = '".$_SESSION['id']."'"));
    if ($arr['hash'] != $_SESSION['hash']) {
        session_unset();
        session_destroy();
    } else {
        $template->set('[username]', $arr['username']);
        $template->set('[avatar]', '/upload/avatars/'.$_SESSION['id'].'.png');
        $db->query("UPDATE `users` SET `lastonline`='".time()."' WHERE id=".$_SESSION['id']);
        if (!file_exists('upload/avatars/'.$_SESSION['id'].'.png')) {
            copy('upload/avatars/noavatar.png', 'upload/avatars/'.$_SESSION['id'].'.png');
        }
    }
} else {
    $template->set('[username]', '');
}

/* Алгоритм вывода страниц */

/* Алгоритм вывода других страниц кроме поиска и главной */
$template->set('[search_result]', '');
$template->set('[page_switch]', '');

switch ($page) {
    case '':
        include 'engine/pages/posts.php';
        break;
    case null:
        include 'engine/pages/posts.php';
        break;
    /* Вывод страницы авторизации */
    case 'login':
        include 'engine/pages/login.php';
        break;
    /* Вывод страницы регистрации */
    case 'register':
        include 'engine/pages/register.php';
        break;
    /* Вывод страницы редактора(создание) постов */
    case 'editor':
        include 'engine/pages/editor.php';
        break;
    /* Вывод страницы редактора(редактирование) постов */
    case 'editpost':
        include 'engine/pages/editpost.php';
        break;
    /* Вывод удаления поста */
    case 'removepost':
        include 'engine/pages/removepost.php';
        break;
    /* Ссылка для завершения сессии */
    case 'logout':
        include 'engine/pages/logout.php';
        break;
    /* Вывод страницы постов конкретного пользователя */
    case 'userposts':
        include 'engine/pages/userposts.php';
        break;
    /* Вывод страницы профиля конкретного пользователя */
    case 'profile':
        include 'engine/pages/profile.php';
        break;
    /* Вывод страницы восстановления пароля */
    case 'lostpassword':
        include 'engine/pages/lostpassword.php';
        break;
    case 'admin':
        include 'engine/pages/admin.php';
        break;
    /* Вывод остальных страниц */
    default:
        include 'engine/pages/other.php';
        break;
}

$template->set('[tpl-link]', '/templates/'.$template_name);

echo $template->out('templates/'.$template_name.'/main.tpl');
