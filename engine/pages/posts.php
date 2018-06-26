<?php



$template->set('[search_result]','');
$template->set('[title]',$site_name);
$postArray = '';
$posts='';

$query = strip_data($_GET['q']);
$page_number= strip_data($_GET['pn']);
if($query==null or $query==''){
    /* Если поиского запроса нет, то выводим главную страницу */
    $page_count = $postOut->pageCountNormal($posts_on_page);
    $postArray = $postOut->postArray($page_number,$posts_on_page,$page_count);
    $posts = $postOut->postList($postArray,$template_name,$template);

 
    $template->set('[content]',$posts);
    
    $pages_switch = $postOut->outSwitch($page_count,$page_number,$page_count);
    $template->set('[page_switch]',$pages_switch);
}else{
    /* Алгоритм поиска постов по тэгам и названию */
    $page_count = $postOut->pageCountSearch($posts_on_page,$query);
    $postArray = $postOut->postArraySearch($page_number,$posts_on_page,$page_count,$query);
    $posts = $postOut->postList($postArray,$template_name,$template);
    $template->set('[content]',$posts);
    $pages_switch = $postOut->outSwitch($page_count,$page_number,$page_count);
    if(mysqli_num_rows($postArray)<1){
        $template->set('[search_result]','Ничего не найдено');
        $template->set('[page_switch]','');
    }else{
        $template->set('[search_result]','Результаты поиска по запросу: '.$query);
        $template->set('[page_switch]',$pages_switch);
    }
}

?>