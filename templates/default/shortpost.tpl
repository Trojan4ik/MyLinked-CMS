<div class=postList>
  <div class="post-header">
    <div class="post-title">
      <a href='[postlink]'>[posttitle]</a>
      [admin]
      <div class="post-title-action">
        <a href="[postremovelink]"><i class="far fa-trash-alt" title="Удалить пост"></i></a>
      </div>
      [/admin]
      [posteditbutton]
    </div>
  </div>
  <div class="post-content">[shortpost]</div>
  <div class="post-footer">
    <div class=tags>
      <script>
        var str = '[tags]';
        var arr = [];
        arr = str.split(',');
        for(var i=0; i<arr.length;i++){
            
            document.write('<div class=tag onclick="window.location.replace('+"'/?q="+arr[i]+"'"+')"><img src=[tpl-link]/img/if_Sed-04_2236329.png height="20px" style="float: left;"><div class=tag-text>'+arr[i]+'</div></div>');
        }
      </script>
    </div>
    <img src="[authoravatar]" style="float:right;margin-left: 10px;margin-right: 5px;height: 37px;">
    <div class = author>Автор: <a href="/?p=userposts&&author=[postauthor]">[postauthor]</a></div>
    <br>
    <div class=date>[postdate]</div>
  </div>
</div>