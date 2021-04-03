<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

class Admin
{
    public function auth($pass)
    {
        $bool = false;
        if($pass == ADMIN_PASS){
            $bool = true;
        }
        return $bool;
    }
}
