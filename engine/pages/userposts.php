<?php

            $author = $_GET['author'];
            if(isset($_GET['author'])){
                $page_count = $postOut->myPageCount($posts_on_page,$author);
                $postArray = $postOut->myPostArray($page_number,$posts_on_page,$page_count,$author);
                $posts = $postOut->postList($postArray,$template_name,$template);
                $template->set('[content]',$posts);
                $pages_switch = $postOut->outSwitch($page_count,$page_number,$page_count);
                if(mysqli_num_rows($postArray)<1){
                    $template->set('[search_result]','Ничего не найдено');
                    $template->set('[page_switch]','');
                }else{
                    $template->set('[search_result]','Посты пользователя: '.$author);
                    $template->set('[page_switch]',$pages_switch);
                }
                $template->set('[title]','Посты пользователя '.$author);
            }else{
                header('Location: /');
                break;
            }
?>