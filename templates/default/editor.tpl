<html>


[logged][activated]

    [result]
    <form method="post" action="">
        

        <input type="text" name="title" placeholder="Название поста" value="[posttitle]"/>
        <br/>
        <input type="text" name="tags" placeholder="Тэги(через запятую)" value="[tags]"/>
        <br/>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=e27bftag7bf54jvgjt5vwj2oi0emm7m7q5qd83mcqxglv1fq"></script> 
        <script>
            
            tinymce.init({
   selector: "textarea",
   plugins: "a11ychecker, advcode, linkchecker, media mediaembed, powerpaste, tinymcespellchecker",
   toolbar: "a11ycheck, code"
});
      
        </script>
        
        <textarea name=problem>
            [problem]
        </textarea>
        <textarea name="solution">
            [solution]
        </textarea>
          
        <input type="submit" value="Сохранить" />
    </form>


[/activated][/logged]

[notlogged]
    Чтобы создавать посты нужно войти или зарегистрироваться!
[/notlogged]
[notactivated]
    Чтобы создавать посты нужно активировать учетную запись!
[/notactivated]

<html>