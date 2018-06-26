<?php
            $id = strip_data($_GET['id']);
            $hash = $_SESSION['hash'];
            if(isset($_SESSION['hash'])){
                if(isset($id) and $id!=''){
                    $user = mysqli_fetch_array($db->query("SELECT permissions FROM users WHERE hash = '".$hash."'"));
                    if($user['permissions']=='2' or $user['permissions']==2){
                        $remove = $db->query("DELETE FROM `posts` WHERE id = $id");
                        $template->set('[content]','Удалено');
                        
                    }else{
                        $template->set('[content]','У вас нет прав, чтобы пользоваться этим');
                    }
                }else{$template->set('[content]','Нет ID');}
            }else{$template->set('[content]','Войдите или зарегистрируйтесь');}
            $template->set('[title]','Удаление поста');
?>