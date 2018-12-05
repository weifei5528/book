<?php
namespace app\index\behavior;

class Test
{
    public function responseSend(&$params)
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:*');
        header('Access-Control-Allow-Credentials:false');
    }
    
}

?>