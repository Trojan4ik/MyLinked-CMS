<?php

            
            $login = strip_data($_POST['login']);
            $email = strip_data($_POST['email']);
            $upassword = strip_data($_POST['password']);
            $name = strip_data($_POST['name']);
            $sn = strip_data($_POST['sn']);
            $result='';

            $response = null;

            $reCaptcha = new ReCaptcha($secret);
            if(isset($_POST) and $login!=null){
            if($login!=null and $email!=null and $upassword!=null and $name!=null and $sn!=null){
                if(preg_match("#^[a-z0-9]+$#i",$login) and preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$email) and preg_match("#^[a-z0-9]+$#i",$upassword)){
                    if(strlen($login)>=5 and strlen($email)>=5 and strlen($upassword)>=6 and strlen($name)>=2 and strlen($sn)>=5){
                        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
                            
                            if ($_POST["g-recaptcha-response"]) {
                                $response = $reCaptcha->verifyResponse(
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["g-recaptcha-response"]
                                );
                            }
                            if ($response != null && $response->success) {
                                $login_exst = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT username FROM users WHERE username = '$login')"));
                                $email_exst = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT email FROM users WHERE email = '$email')"));
                                if($login_exst[0]<=0 and $email_exst[0]<=0){
                                    $newPass = addslashes(htmlspecialchars(substr(md5(md5($upassword).$sault), 0, 20))).$sault;
                                    $actCode = md5(rand(5, 1500));
                                    $reg_req = $db->query("INSERT INTO users(name, email, username, password,sn,activation) VALUES('$name','$email', '$login', '$newPass','$sn','$actCode')");
                                    if($reg_req){
                                        $result = 'Регистрация прошла успешно! Письмо с активацией должно прийти вам на почту!';
                                        $body = str_replace('%login%',$login,$body);
                                        $body = str_replace('%actcode%',$actCode,$body);
                                        Send_Mail($email,$subject,$body);
                                    }else{
                                        $result = 'Что-то пошло не так...';
                                    }
                                }else { $result = 'Такой логин или E-Mail уже зарегистрирован!';}
                            } else {
                                $result = 'Вы не прошли капчу!';
                            }
                        }else{ $result = 'Введите верный E-Mail'; }
                    }else{ $result = 'Некоторые поля не заполнены, либо в них слишком мало символов'; }
                }else{ $result = 'Разрешено использовать только символы a-Z, 0-9'; }
            }else{ $result = 'Вы заполнили не все поля!'; }}
            else{
                if(isset($_SESSION['hash'])){
                    $template->set('[content]','');
                    header('Location: /');
                    exit;
                }else{
                    $template->set('[content]',$template->out('templates/'.$template_name.'/register.tpl'));
                }
            }
            $template->set('[result]',$result);
            $template->set('[title]','Регистрация');
            

?>