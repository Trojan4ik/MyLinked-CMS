<?php

            session_unset();
            session_destroy();
            $template->set('[content]','Выходим...');
            header('Location: /');

?>