<?php
/* Если в ссылке число то скорее всего это ID поста, поэтому выводим пост с этим ID, а если все-таки такого поста нет,
то шлем на главную страницу*/
if (is_numeric($page)) {
    $post = $db->query('SELECT EXISTS(SELECT id FROM posts WHERE id = '.$page.')');
    $row = mysqli_fetch_array($post);
    if ($row[0] > 0) {
        $post = $db->query('SELECT title, problem, solution, date, author FROM posts WHERE id = '.$page);
        $row = mysqli_fetch_array($post);
        $template->set('[posttitle]', $row['title']);
        $template->set('[title]', $row['title']);
        $template->set('[problem]', $row['problem']);
        $template->set('[solution]', $row['solution']);
        $template->set('[date]', $row['date']);
        $template->set('[author]', $row['author']);
        $template->set('[content]', $template->out('templates/'.$template_name.'/fullpost.tpl'));
    } else {
        header('Location: /');
        exit;
    }
} else {
    /* Если ссылка ни на что не похожа, то будем считать что это статическая страница,
    поэтому если этот файл существует то выводим его, а если нет, то шлем нахуй с такими запросами*/
    if (file_exists('templates/'.$template_name.'/'.$page.'.tpl')) {
        $template->set('[content]', $template->out('templates/'.$template_name.'/'.$page.'.tpl'));
    } else {
        header('Location: /');
        exit;
    }
}
