<?php

class config
{
    public $template_name = 'default';

    public $posts_on_page = 5;

    public $sault = 'ADQ@eafctS';

    public $site_name = 'MyLinked.ru';

    public $host = 'localhost';
    public $user = 'trojan4ik';
    public $password = '';
    public $database = 'c9';

    public $lang = 'ru-RU.json';

//Mail
    public $subject = 'MyLinked';
    public $body_lost_p = 'Здравствуйте!<br/> Чтобы восстановить пароль, перейдите по ссылке: http://forum-trojan4ik.c9users.io/?p=lostpassword&lp=%hash% <hr>';

    public $body = 'Здравствуйте, %login%!<br/> Спасибо, что зарегистрировались на MyLinked.ru <br> Остался всего один шаг, и вы сможете воспользоваться функционал сайта. <br> Подтвердите свой e-mail по ссылке http://forum-trojan4ik.c9users.io/?activation=%actcode% <hr> Сразу после подтверждения мы активируем вашу учётную запись. Чтобы в него войти, используйте e-mail и пароль.';
}
$config = new config();
