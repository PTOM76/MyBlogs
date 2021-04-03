<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

class MainLoader{
    public function __construct(){
        global $main_class, $url_var, $contents_data;
        $this->langLoader();
        $main_class->createUrlVars();
        $main_class->getPageName();
        if(!isset($url_var['do'])||$url_var['do'] == "show"){
            $contents_data = $this->pageLoader($url_var['page']);
        }else{
            $contents_data = $main_class->do();
        }
        $this->skinLoader();
    }

    public function langLoader(){
        require(LANG_PATH . LANG . ".php");
    }

    public function skinLoader(){
        // スキンの読み込み
        $_html = file_get_contents(SKIN_PATH . SKIN . "/design.html");
        $_html = sw_html_replace($_html);
        echo $_html;
    }

    public function pageLoader($pagename){
        global $lang;
        if(file_exists(ARTICLE_PATH . bin2hex($pagename))){
            $_html = file_get_contents(ARTICLE_PATH . bin2hex($pagename));
        }else{
            $_error = sw_str_replace("\$1", $pagename, $lang["not_found_article"]);
            $_error2 = sw_str_replace("\$1", $pagename, $lang["admin_question"]);
            $_html = <<<EOD
                <h2>{$_error}</h2>
                {$_error2}
            EOD;
        }
        // プラグイン表現文字の変換
        $_html = plugin_convert($_html);
        return $_html;
    }
}