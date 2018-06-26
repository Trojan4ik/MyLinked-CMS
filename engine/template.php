<?php
include('db.php');

if (! defined ( 'READFILE' ))
{
	exit ( "Error, wrong way to file.<br><a href=\"/\">Go to main</a>." );
}
class template extends db{
    
    var $vars = array();
    var $content;
    
    function set($name, $val){
        $this->vars[$name] = $val;
    }
    function strip_data($text)
    {
        $quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" );
        $goodquotes = array ("-", "+", "#" );
        $repquotes = array ("\-", "\+", "\#" );
        $text = trim( strip_tags( $text ) );
        $text = str_replace( $quotes, '', $text );
        $text = str_replace( $goodquotes, $repquotes, $text );
        $text = ereg_replace(" +", " ", $text);
            
        return $text;
    }
    function out($tpl){
        $this->content = file_get_contents($tpl);

        preg_match_all('/\[logged\](.*)\[\/logged\]/is', $this->content, $logged);
        preg_match_all('/\[notlogged\](.*)\[\/notlogged\]/is', $this->content, $notlogged);
        preg_match_all('/\[admin\](.*)\[\/admin\]/is', $this->content, $admin);
        preg_match_all('/\[activated\](.*)\[\/activated\]/is', $this->content, $activated);
        preg_match_all('/\[notactivated\](.*)\[\/notactivated\]/is', $this->content, $notactivated);
        preg_match_all('/\[editprofile\](.*)\[\/editprofile\]/is', $this->content, $editprofile);
        
        if(isset($_SESSION['id']) and isset($_SESSION['hash'])){
            foreach($notlogged[1] as $key=>$val){
                $this->content = str_replace('[notlogged]'.$val.'[/notlogged]','',$this->content);
            }
            foreach($logged[1] as $key=>$val){
                
                $this->content = str_replace('[logged]'.$val.'[/logged]',$val,$this->content);
            }
        }
        else{
            
            foreach($notlogged[1] as $key=>$val){
                $this->content = str_replace('[notlogged]'.$val.'[/notlogged]',$val,$this->content);
            }
            foreach($logged[1] as $key=>$val){
                
                $this->content = str_replace('[logged]'.$val.'[/logged]','',$this->content);
            }
        }
        
        if(isset($_SESSION['id']) and isset($_SESSION['hash'])){
            $isAdmin = mysqli_fetch_array($this->query("SELECT permissions FROM users WHERE hash ='".$_SESSION['hash']."'"));
            if($isAdmin['permissions']==2){
                foreach($admin[1] as $key=>$val){
                    $this->content = str_replace('[admin]'.$val.'[/admin]',$val,$this->content);
                }
            }else{
                foreach($admin[1] as $key=>$val){
                    $this->content = str_replace('[admin]'.$val.'[/admin]','',$this->content);
                }
            }
        }
        else{
            foreach($admin[1] as $key=>$val){
                $this->content = str_replace('[admin]'.$val.'[/admin]','',$this->content);
            }
        }
        
        if(isset($_SESSION['id']) and isset($_SESSION['hash'])){
            $isAct = mysqli_fetch_array($this->query("SELECT permissions FROM users WHERE hash ='".$_SESSION['hash']."'"));
            if($isAct['permissions']>=1){
                foreach($notactivated[1] as $key=>$val){
                    $this->content = str_replace('[notactivated]'.$val.'[/notactivated]','',$this->content);
                }
                foreach($activated[1] as $key=>$val){
                    $this->content = str_replace('[activated]'.$val.'[/activated]',$val,$this->content);
                }
            }else{
                foreach($notactivated[1] as $key=>$val){
                    $this->content = str_replace('[notactivated]'.$val.'[/notactivated]',$val,$this->content);
                }
                foreach($activated[1] as $key=>$val){
                    $this->content = str_replace('[activated]'.$val.'[/activated]','',$this->content);
                }
            }
        }
        else{
            foreach($notactivated[1] as $key=>$val){
                $this->content = str_replace('[notactivated]'.$val.'[/notactivated]','',$this->content);
            }
            foreach($activated[1] as $key=>$val){
                $this->content = str_replace('[activated]'.$val.'[/activated]','',$this->content);
            }
        }
        if(isset($_SESSION['id']) and isset($_SESSION['hash']) and $_GET['p']=='profile' and isset($_GET['user'])){
            $user = $this->strip_data($_GET['user']);
            $userArr = mysqli_fetch_array($this->query("SELECT hash from users where username = '".$user."'"));
            if($userArr['hash']==$_SESSION['hash']){
                foreach($editprofile[1] as $key=>$val){
                    $this->content = str_replace('[editprofile]'.$val.'[/editprofile]',$val,$this->content);
                }
            }else{
                foreach($editprofile[1] as $key=>$val){
                    $this->content = str_replace('[editprofile]'.$val.'[/editprofile]','',$this->content);
                }
            }
            
        }else{
                foreach($editprofile[1] as $key=>$val){
                    $this->content = str_replace('[editprofile]'.$val.'[/editprofile]','',$this->content);
                }
        }
        
        
        foreach($this->vars as $key=>$val){
            $this->content = str_replace($key,$val,$this->content);
        }
        

        
        return $this->content;
    }
    
}
$template = new template;


?>