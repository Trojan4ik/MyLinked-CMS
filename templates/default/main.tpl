<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>[title]</title>
        <link rel="stylesheet" href="[tpl-link]/css/style.css" type="text/css"/>
        <link rel="stylesheet" href="[tpl-link]/css/clear.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <script src="engine/modules/search/search.js"></script>
        <link rel="shortcut icon" href="[tpl-link]/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="[tpl-link]/img/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div class=header>
            <div class=menu>
                <div class="home_btn"><a href="/"><img src="[tpl-link]/img/logo.png"></a></div>
                <input type="text" name="referal" placeholder="Поиск..." value="" class="who" style="margin:auto;" autocomplete="off">
                <div class=search_button style="display:none"></div>
                <ul class="search_result"></ul>
                [notlogged]
                <div class="user_btn_notlogged"><a href="/?p=login"><img src="[tpl-link]/img/no-login.png"></a></div>
                [/notlogged]
                [logged]
                
                <div class="user_btn_logged">
                    <img src="[avatar]">
                    <div class="drop_user_content">
                        <a href="/?p=editor"><i class="far fa-plus-square" style="width: 15px;margin-right: 5px;"></i> Добавить запись</a>
                        <a href="/?p=userposts&&author=[username]"><i class="far fa-folder" style="width: 15px;margin-right: 5px;"></i> Мои записи</a>
                        <a href="/?p=profile&&user=[username]"><i class="far fa-id-card" style="width: 15px;margin-right: 5px;"></i> Настройки</a>
                        [admin]
                        <hr>
                        <a href="/" class="disable-link"><i class="fas fa-cogs" style="width: 15px;margin-right: 5px;"></i> Админпанель</a>
                        [/admin]
                        <hr>
                        <a href="/?p=logout"><i class="fas fa-sign-out-alt" style="width: 15px;margin-right: 5px;"></i> Выход</a>
                    </div>
                </div>
 
                [/logged]
            </div>
        </div>
        <div class = content>
            [search_result]
            
            <div class="content_left">[content]</div>
            <div class="content_right">
                <div class="content_right_box">
                    <div class="content_right_box_title">Топ тегов</div>
                    <div class="content_right_box_content">
                        dle [12], tag [8], linux [5], php [4]
                    </div>
                </div>
            </div>
            <div class="page_switch">[page_switch]</div>
        </div>
        
        <div class=footer>
            <div class=footer-text>Сайт разработан командой проекта <a href="http://mgserv.ru" target="_blank">MegaLands [MGServ]</a> © 2017-2018<br>Копирование материалов без ссылки на наш источник нежелателен.</div>
        </div>
    </body>
</html>