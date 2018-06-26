<?php

if (!defined('READFILE')) {
    exit('Error, wrong way to file.<br><a href="/">Go to main</a>.');
}
require_once 'config.php';
require_once 'db.php';
require_once 'template.php';

class postOut extends db
{
    public function pageCount($posts_on_page, $query)
    {
        return ceil(mysqli_fetch_array($this->query($query))[0] / $posts_on_page);
    }

    public function postArray($page_number, $posts_on_page, $page_count)
    {
        if ($page_number == null or $page_number == '') {
            $page_number = 0;
            $postArray = $this->query("SELECT DATE_FORMAT(date,'%d.%m.%Y %H:%i') AS date, title,id,author,tags,problem,hash FROM posts ORDER BY date DESC LIMIT 0,".$posts_on_page);

            return $postArray;
        } else {
            if ($page_number >= 1 && $page_number <= $page_count) {
                $page_number = $page_number - 1;
                $postArray = $this->query("SELECT DATE_FORMAT(date,'%d.%m.%Y %H:%i') AS date,title,id,author,tags,problem,hash FROM posts ORDER BY date DESC LIMIT ".($posts_on_page * $page_number).','.($posts_on_page));

                return $postArray;
            } else {
                header('Location: /');
                exit;
            }
        }
    }

    public function postList($postArray, $template_name, $template)
    {
        $posts = '';
        for ($i = 0; $i <= mysqli_num_rows($postArray) - 1; ++$i) {
            $myrow = mysqli_fetch_array($postArray);

            $post = $template->out('templates/'.$template_name.'/shortpost.tpl');
            $post = str_replace('[posttitle]', $myrow['title'], $post);
            $post = str_replace('[postlink]', '/?p='.$myrow['id'], $post);
            if (isset($_SESSION['id'])) {
                $isadmin = mysqli_fetch_array($this->query('SELECT permissions FROM users WHERE id='.$_SESSION['id']." AND hash='".$_SESSION['hash']."'"));
                $hashPost = $myrow['hash'];
                $hashCookie = $_COOKIE[$myrow['id']];
                if ($hashPost == $hashCookie or $isadmin['permissions'] == 2) {
                    $post = str_replace('[posteditbutton]', $template->out('templates/'.$template_name.'/editbutton.tpl'), $post);
                    $post = str_replace('[posteditlink]', '/?p=editpost&&id='.$myrow['id'], $post);
                } else {
                    $post = str_replace('[posteditlink]', '', $post);
                    $post = str_replace('[posteditbutton]', '', $post);
                }
            } else {
                $post = str_replace('[posteditlink]', '', $post);
                $post = str_replace('[posteditbutton]', '', $post);
            }

            $post = str_replace('[postremovelink]', '/?p=removepost&&id='.$myrow['id'], $post);
            $avatar = mysqli_fetch_array($this->query("SELECT id FROM users WHERE username='".$myrow['author']."'"));
            $post = str_replace('[authoravatar]', '/upload/avatars/'.$avatar['id'].'.png', $post);
            $post = str_replace('[postdate]', $myrow['date'], $post);
            $post = str_replace('[postauthor]', $myrow['author'], $post);
            $post = str_replace('[tags]', $myrow['tags'], $post);
            $post = str_replace('[shortpost]', rtrim(substr($myrow['problem'], 0, 100), '!,.-').'...', $post);
            $posts = $posts.$post;
        }

        return $posts;
    }

    public function outSwitch($page_count, $page_number, $page_count)
    {
        $pages_switch = '';
        if ($page_number == null) {
            $page_number = 1;
        }
        if ($page_count <= 1) {
            $pages_switch = '';
        } else {
            for ($i = 1; $i <= $page_count; ++$i) {
                if ($page_number == $i) {
                    $pages_switch = $pages_switch.'<a href=/?pn='.$i.' style = "color:black;pointer-events: none;">'.$i.'</a>';
                } else {
                    $pages_switch = $pages_switch.'<a href=/?pn='.$i.' >'.$i.'</a>';
                }
            }
        }

        return $pages_switch;
    }

    public function pageCountNormal($posts_on_page)
    {
        return $this->pageCount($posts_on_page, 'SELECT COUNT(id) FROM posts');
    }

    //////////////////////
    /////SEARCH///////////
    //////////////////////
    public function pageCountSearch($posts_on_page, $query)
    {
        return $this->pageCount($posts_on_page, "SELECT COUNT(id) FROM posts WHERE tags LIKE '%$query%' OR title LIKE '%$query%'");
    }

    public function postArraySearch($page_number, $posts_on_page, $page_count, $query)
    {
        if ($page_number == null or $page_number == '') {
            $page_number = 0;

            return $this->query("SELECT DATE_FORMAT(date,'%d.%m.%Y %H:%i') AS date, id, title, tags, author, problem,hash from posts WHERE tags LIKE '%$query%' OR title LIKE '%$query%' ORDER BY date DESC LIMIT 0,".$posts_on_page);
        } else {
            if ($page_number >= 1 && $page_number <= $page_count) {
                $page_number = $page_number - 1;

                return $this->query("SELECT DATE_FORMAT(date,'%d.%m.%Y %H:%i') AS date, id, title, tags, author, problem,hash from posts WHERE tags LIKE '%$query%' OR title LIKE '%$query%' ORDER BY date DESC LIMIT ".($posts_on_page * $page_number).','.($posts_on_page));
            } else {
                header('Location: /');
                exit;
            }
        }
    }

    public function myPostArray($page_number, $posts_on_page, $page_count, $author)
    {
        if ($page_number == null or $page_number == '') {
            $page_number = 0;

            return $this->query("SELECT DATE_FORMAT(date,'%d.%m.%Y %H:%i') AS date, id, title, tags, author, problem,hash from posts WHERE author='$author' ORDER BY date DESC LIMIT 0,".$posts_on_page);
        } else {
            if ($page_number >= 1 && $page_number <= $page_count) {
                $page_number = $page_number - 1;

                return $this->query("SELECT DATE_FORMAT(date,'%d.%m.%Y %H:%i') AS date, id, title, tags, author, problem,hash from posts WHERE author='$author' ORDER BY date DESC LIMIT ".($posts_on_page * $page_number).','.($posts_on_page));
            } else {
                header('Location: /');
                exit;
            }
        }
    }

    public function myPageCount($posts_on_page, $author)
    {
        return $this->pageCount($posts_on_page, "SELECT COUNT(id) FROM posts WHERE author = '$author'");
    }
}
$postOut = new postOut();
