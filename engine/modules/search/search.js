$(function(){
    
//Живой поиск
$('.who').bind("change keyup input click", function() {
    
    if(this.value.length >= 2){
        $.ajax({
            type: 'post',
            url: "engine/modules/search/search.php", //Путь к обработчику
            data: {'referal':this.value},
            response: 'text',
            success: function(data){
               // $(".search_result").html(data).fadeIn();
                if(data.length>0){
                     $(".search_result").html(data).fadeIn();
      
                    
                }else{$(".search_result").html(data).fadeOut();}
           }
       })
    }
})
    
$(".search_result").hover(function(){
    $(".who").blur(); //Убираем фокус с input
})
    
//При выборе результата поиска, прячем список и заносим выбранный результат в input
$(".search_result").on("click", "li", function(e){
    s_user = $(this).text();
    //var input = document.getElementById('input');
    //input.value=e.target.innerHTML;
    //$(".who").val(s_user).attr('enabled', 'disabled'); //деактивируем input, если нужно
    $(".search_result").fadeOut();

    var postID = $(".postid").text();
    var postIDnew;
    var postIndex = $(this).index();
    for(var i = 0;i<=postID.length;i++){
        
        postIDnew = postIDnew+postID[i];
    }
    
    postIDnew = postIDnew.replace("undefined","")
    postIDnew = postIDnew.replace("undefined","")
    window.location.replace('/?p='+postIDnew); 
})
$("body").on("click", function(){
    //$(".who").val(s_user).attr('disabled', 'disabled'); //деактивируем input, если нужно
    $(".search_result").fadeOut();
})
$(".search_button").on("click",function(){
    s_user = $(this).text();
    window.location.replace('/?q='+$('input[name="referal"]').val()); 
})
$(".who").on('keyup', function(e){
    if(e.keyCode==13) {
        $('.search_button').click();
        
    }
      
})
})