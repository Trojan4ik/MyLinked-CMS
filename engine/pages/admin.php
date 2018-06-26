<?php

$hash = $_SESSION['hash'];
if (isset($_SESSION['hash'])) {
    $user = mysqli_fetch_array($db->query("SELECT permissions FROM users WHERE hash = '".$hash."'"));
    if ($user['permissions'] == '2' or $user['permissions'] == 2) {
        $template->set('[content]', $template->out('templates/'.$template_name.'/admin.tpl'));
    } else {
        $template->set('[content]', 'У вас нет прав, чтобы пользоваться этим');
    }
} else {
    $template->set('[content]', 'Войдите или зарегистрируйтесь');
}
$template->set('[title]', 'Админ-панель');
