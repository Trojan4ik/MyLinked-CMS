<?php
            $user = strip_data($_GET['user']);
            $userexst = mysqli_fetch_array($db->query("SELECT EXISTS(SELECT username FROM users WHERE username ='".$user."')"));
            if(isset($user) and $userexst[0]>0){
                $userArr = mysqli_fetch_array($db->query("SELECT id,username,sn,email,name,hash FROM users WHERE username = '".$user."'"));
                
                /* Если пользователи совпадают то выводим редактор профиля */
                if(isset($_SESSION['id']) and isset($_SESSION['hash']) and $_SESSION['hash']==$userArr['hash'] ){
                    
                    $template->set('[email]',$userArr['email']);
                    $nemail = strip_data($_POST['newemail']);
                    $nname = strip_data($_POST['newname']);
                    $nsn = strip_data($_POST['newsn']);
                    $npassword = strip_data($_POST['newpassword']);
                    $opassword = strip_data($_POST['oldpassword']);
                    $result = '';
                    /* Если пользователь сохраняет новый E-Mail(а это мы проверяем тем, что поле с E-Mail не пустое),
                    то мы сохраняем именно это, а не что-то другое или все вместе и так со всеми остальными полями */
                    if(isset($nemail) and strlen($nemail)!=0){
                        if($nemail!=null and $nemail!=''){
                            if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$nemail) and filter_var($nemail, FILTER_VALIDATE_EMAIL) !== false and strlen($nemail)>5){
                                $actCode = md5(rand(5, 1500));
                                $add_req = $db->query("UPDATE `users` SET `email`='$nemail', permissions=0, activation = '$actCode' WHERE id=".$_SESSION['id']);
                                $result = 'Письмо с подтверждением отправленно вам на почту.';
                                $body = str_replace('%login%','',$body);
                                $body = str_replace('%actcode%',$actCode,$body);
                                Send_Mail($nemail,$subject,$body);
                                header("Refresh:0");
                                exit;
                            }else{ $result='Введите корректный email';}
                        }else{ $result='Введите корректный email';}
                    }
                    if(isset($nname) and strlen($nname)!=0){
                        if(strlen($nname)>2 and $nname!=null and $nname!='' and strlen($nname)<20){
                            $add_req = $db->query("UPDATE `users` SET `name`='$nname' WHERE id=".$_SESSION['id']);
                            header("Refresh:0");
                            exit;
                            $result = 'OK.';
                        }else{ $result='Имя должно быть больше двух символов';}
                        
                    }
                    if(isset($nsn) and strlen($nsn)!=0){
                        if(strlen($nsn)>3 and $nsn!=null and $nsn!='' and strlen($nsn)<30){
                            $add_req = $db->query("UPDATE `users` SET `sn`='$nsn' WHERE id=".$_SESSION['id']);
                            $result = 'OK.';
                            header("Refresh:0");
                            exit;
                        }else{ $result='Минимальное кол-во символов = 3';}
                    }
                    if(isset($npassword) and strlen($npassword)!=0 and isset($opassword)){
                        if(preg_match("#^[a-z0-9]+$#i",$npassword)){
                            if(strlen($npassword)>6){
                                if($npassword!=$opassword){
                                    $md5opassword = addslashes(htmlspecialchars(substr(md5(md5($opassword).$sault), 0, 20))).$sault;
                                    if($md5opassword==$userArr['password']){
                                        $md5npassword = addslashes(htmlspecialchars(substr(md5(md5($npassword).$sault), 0, 20))).$sault;
                                        $add_req = $db->query("UPDATE `users` SET `password`='$md5npassword' WHERE id=".$_SESSION['id']);
                                        $result="Пароль обновлен";
                                        
                                    }else{$result='Вы ввели неправильный старый пароль!';}
                                }else{$result='Старый и новый пароли не должны совпадать';}
                            }else{$result='Минимальное кол-во символов = 6';}
                        }else{$result='Разрешены только латинские буквы и цифры';}
                    }
                    
                    if($_FILES){
                         if(  is_uploaded_file($_FILES['avatar']["tmp_name"])  ){
                             if($_FILES['avatar']['type']=='image/jpeg' or $_FILES['avatar']['type']=='image/png'){
                                 if($_FILES['avatar']['size']<0.5*1024*1024){
                                     if($_FILES['avatar']['type']=='image/jpeg'){
                                         $image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
                                     }
                                     if($_FILES['avatar']['type']=='image/png'){
                                          $image = imagecreatefrompng($_FILES['avatar']['tmp_name']);
                                     }
                                     $size = getimagesize($_FILES['avatar']['tmp_name']);
                                     $tmp = imagecreatetruecolor(256,256);
                                     imagealphablending($tmp,false);
                                     imagesavealpha($tmp,true);
                                     imagecopyresampled($tmp,$image,0,0,0,0,256,256,$size[0],$size[1]);
                                     imagepng($tmp, 'upload/avatars/'.$_SESSION['id'].'.png');
                                     imagedestroy($tmp);
                                     header("Refresh:0");
                                     exit;
                                     $result='Изображение загружено';
                                 }else{$result = 'Файл должен быть меньше 0.5 мб';}
                             }else{$result = 'Файл должен быть JPEG или PNG';}
                         }
                         
                    }
                    if($_GET['avatar']=='remove'){
                        copy('upload/avatars/noavatar.png', 'upload/avatars/'.$_SESSION['id'].'.png');
                    }
                    $template->set('[avatar-remove]','/?p=profile&user='.$userArr['username'].'&avatar=remove');
                    $template->set('[result]',$result);
                }else{
                    $template->set('[email]','');
                    $template->set('[result]','');
                }
                /* Вывод тэгов делаем в последнюю очередь, когда все операции уже выполнены */
                $template->set('[login]',$userArr['username']);
                $template->set('[id]',$userArr['id']);
                $template->set('[avatar]',"upload/avatars/".$userArr['id'].'.png');
                $template->set('[name]',$userArr['name']);
                $template->set('[sn]',$userArr['sn']);
                $template->set('[title]','Профил пользователя '.$userArr['username']);
                $template->set('[content]',$template->out('templates/'.$template_name.'/profile.tpl'));
            }else{
                header('Location: /');
                break;
            }

?>