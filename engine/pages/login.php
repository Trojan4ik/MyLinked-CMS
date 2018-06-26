<?php

$template->set('[title]', 'Вход на сайт');
$result = '';
$email = strip_data($_POST['email']);
$upassword = strip_data($_POST['password']);
/* МД5 расшифровать нельзя, поэтому  */
$newPass = addslashes(htmlspecialchars(substr(md5(md5($upassword).$sault), 0, 20))).$sault;

$response = null;

if (isset($_POST) and $email != null) {
    if ($email != null and $upassword != null) {
        if (strlen($email) >= 5 and strlen($upassword) >= 6) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
                $reCaptcha = new ReCaptcha($secret);
                if ($_POST['g-recaptcha-response']) {
                    $response = $reCaptcha->verifyResponse(
                    $_SERVER['REMOTE_ADDR'],
                    $_POST['g-recaptcha-response']
                    );
                }
                if ($response != null && $response->success) {
                    $exst = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT email FROM users WHERE email = '$email' AND password = '$newPass')"));
                    $pass = mysqli_fetch_array($db->query("SELECT password,id,hash FROM users WHERE email = '$email'"));

                    if ($exst[0] == 1 and $pass['password'] == $newPass) {
                        $hash = md5(generateCode(10));
                        session_start();
                        $_SESSION['id'] = $pass['id'];
                        $_SESSION['hash'] = $hash;

                        $db->query("UPDATE `users` SET hash = '$hash' WHERE id =".$pass['id']);
                        $template->set('[content]', '');
                        header('Location: /');
                        exit;
                    } else {
                        $result = '<div class="login_error">Введены неверные логин/пароль</div>';
                    }
                } else {
                    $result = '<div class="login_error">Капча не прошла проверку!</div>';
                }
            } else {
                $result = '<div class="login_error">Введены неверный E-Mail</div>';
            }
        } else {
            $result = '<div class="login_error">Введены неверные логин/пароль</div>';
        }
    } else {
        $result = '<div class="login_error">Вы заполнили не все поля!</div>';
    }
}
if (isset($_SESSION['hash'])) {
    $template->set('[content]', '');
    header('Location: /');
    exit;
} else {
    $template->set('[content]', $template->out('templates/'.$template_name.'/auth.tpl'));
}
$template->set('[result]', $result);
