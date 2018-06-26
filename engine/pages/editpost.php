<?php

 $result='';
            $id = strip_data($_GET['id']);
            $title = strip_data($_POST['title']);
            $tags = strip_data($_POST['tags']);
            $problem = $_POST['problem'];
            $solution = $_POST['solution'];
            $hash = $_COOKIE[$id];
            $template->set('[content]',$template->out('templates/'.$template_name.'/editor.tpl'));
            
            if(isset($_SESSION['hash'])){
                $isadmin = mysqli_fetch_array($db->query("SELECT permissions FROM users WHERE id = ".$_SESSION['id']." AND hash = '".$_SESSION['hash']."'"));
                if((isset($_COOKIE[$id]) and $_COOKIE[$id]!='') or $isadmin['permissions']==2){
                    $hashPost = mysqli_fetch_array($db->query("SELECT hash FROM posts WHERE id = ".$id.""));
                    
                    if($hash==$hashPost['hash'] or $isadmin['permissions']==2){
                        $postdata = mysqli_fetch_array($db->query("SELECT * FROM posts WHERE id = ".$id.""));
                        $template->set('[posttitle]',$postdata['title']);
                        $template->set('[tags]',$postdata['tags']);
                        $template->set('[problem]',$postdata['problem']);
                        $template->set('[solution]',$postdata['solution']);
                        
                        if(isset($_POST) and $_POST['title']!=null){
                            if($title!=null and $tags!=null and $problem!=null and $solution!=null){
                                if(strlen($title)>5 and strlen($tags)>5 and strlen($problem)>20 and strlen($solution)>20){
                                    $problem = mysqli_real_escape_string($db->linkD,$problem);
                                    $solution = mysqli_real_escape_string($db->linkD,$solution);
                                    $add_req = $db->query("UPDATE `posts` SET `title`='$title',`tags`='$tags',`problem`='$problem',`solution`='$solution' WHERE id=".$id);
                                    header('Location: /');
                                    exit;
                                }else{ $result = 'Слишком мало информации в посте!'; }
                            }else{ $result = 'Вы заполнили не все поля!'; }
                        }
                    }else{ $result = 'Вы не можете редакировать этот пост!';
                        $template->set('[content]','[result]');
                    }
                }else{ $result = 'Вы не можете редакировать этот пост!';
                    $template->set('[content]','[result]');
                }
            }else{ //$result = 'Для начала войдите или зарегистрируйтесь!'; 
                $template->set('[content]','[result]');
            }
            $template->set('[result]',$result);
            $template->set('[title]','Создание/редактирование поста');

?>