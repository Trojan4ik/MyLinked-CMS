<?php

include 'config.php';

class db extends config
{
    public $linkD;

    public function query($query)
    {
        $this->linkD = mysqli_connect($this->host, $this->user, $this->password, $this->database)
            or die('Ошибка '.mysqli_error($this->linkD));

        $result = mysqli_query($this->linkD, $query) or die('Ошибка '.mysqli_error($this->linkD));
        if ($result) {
            return $result;
        }
        mysqli_close($this->linkD);
    }
}
$db = new db();
