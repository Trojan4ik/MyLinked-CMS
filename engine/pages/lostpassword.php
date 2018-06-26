<?php

            $email = strip_data($_POST['email']);
            $lp = strip_data($_GET['lp']);
            $result = '';
            /* Первый этап восстановления - отсылка письма на почту пользователя с хэшем его последней авторизации
            (данный метод безопасен, потому что при каждой авторизации хэш меняется, а от самого пользователя прятать его хэш нет смысла) */
            if(isset($email) and $email!=''and $email!=null){
                $row = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT email FROM users WHERE email = '".$email."')"));
                if($row[0]>0){
                    $user = mysqli_fetch_array($db->query("SELECT hash from users where email = '$email'"));
                    
                    $body_lost_p = str_replace('%hash%',$user['hash'],$body_lost_p);
                    Send_Mail($email,$subject,$body_lost_p);
                    $result = "Письмо с сылкой для смены пароля отправленно вам на почту!";
                    
                }else{$result = "Такой email не зарегистрирован!";}
            }
            /* Если уже получен хэш от пользователя и он верный, то даем ему изменить пароль */
            if(isset($lp) and $lp!='' and $lp !=null){
                
                $template->set('[content]',$template->out('templates/'.$template_name.'/lostpassword_2.tpl'));
                $npassword = strip_data($_POST['newpassword']);
                $userArr = mysqli_fetch_array($db->query("SELECT id,username,sn,email,name,password FROM users WHERE hash = '".$lp."'"));
                $opassword=$userArr['password'];
                $row = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT hash FROM users WHERE hash = '".$lp."')"));
                
                if(isset($npassword) and strlen($npassword)!=0 and isset($opassword)){
                    if($row[0]>0){
                    if(preg_match("#^[a-z0-9]+$#i",$npassword)){
                        if(strlen($npassword)>6){
                            if($npassword!=$opassword){
                                
                                $md5npassword = addslashes(htmlspecialchars(substr(md5(md5($npassword).$sault), 0, 20))).$sault;
                                $add_req = $db->query("UPDATE `users` SET `password`='$md5npassword' WHERE hash='$lp'");
                                $result="Пароль обновлен";
                                
                            }else{$result='Старый и новый пароли не должны совпадать';}
                        }else{$result='Минимальное кол-во символов = 6';}
                    }else{$result='Разрешены только латинские буквы и цифры';}
                    }else{$result='Неверная ссылка на восстановление';}
                }
                
            }else{
                $template->set('[content]',$template->out('templates/'.$template_name.'/lostpassword.tpl'));
            }
             $template->set('[title]','Восстановление пароля');
             $template->set('[result]',$result);

?>