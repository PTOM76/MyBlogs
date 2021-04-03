<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

function sw_html_replace($data){
    global $contents_data, $head_elements, $pluginloader_class;
    $data = sw_str_replace("\$TITLE;", TITLE, $data);
    $data = sw_str_replace("\$CONTENTS;", $contents_data, $data);
    $data = sw_str_replace("\$HEAD_ELEMENTS;", implode("\n",$head_elements), $data);
    $data = sw_str_replace("\$SKIN_PATH;", SKIN_PATH  . SKIN, $data);
    $data = sw_str_replace("\$IMAGE_PATH;", IMAGE_PATH, $data);
    $data = sw_str_replace("\$SUMMARY;", SUMMARY, $data);
    $data = sw_str_replace("\$FOOTER;", FOOTER_INFO, $data);
    if(!isset($pluginloader_class)){
        $pluginloader_class = new PluginLoader();
    }
    $data = $pluginloader_class->pluginConvert($data);
    return $data;    
}

function sw_str_replace($search, $replace, $subject, &$count = null){
    $var = str_replace($search, $replace, $subject, $count);
    return $var;
}

function cache_page_dates($pagename){
    $path = ARTICLE_PATH . bin2hex($pagename);
    if (!file_exists(CACHE_PATH . cache_page_dates_file)) {
        file_put_contents(CACHE_PATH . cache_page_dates_file, "");
    }else{

        $txt = file_get_contents(CACHE_PATH . cache_page_dates_file);

        // 16進数の同じページ名を含む行を削除
        $txt = preg_replace('/^\'' . bin2hex($pagename) . '\'.*$/um', '', $txt);
        // 先頭へ追加
        $txt = "\n'" . bin2hex($pagename) . "','" . filemtime($path) . "'" . $txt;
        $txt = preg_replace('/[\r\n]{2,}/', "\n", $txt);
        // 保存
        $write = file_put_contents(CACHE_PATH . cache_page_dates_file, $txt);
    }
    return $write;
}

function makedirs(){
    $makeddirs = '';
    if (!file_exists(ARTICLE_PATH)) {
        mkdir(ARTICLE_PATH);
        $makeddirs .= ARTICLE_PATH . ',' ;
    }
    if (!file_exists(IMAGE_PATH)) {
        mkdir(IMAGE_PATH);
        $makeddirs .= IMAGE_PATH . ',' ;
    }
    if (!file_exists(CACHE_PATH)) {
        mkdir(CACHE_PATH);
        $makeddirs .= CACHE_PATH . ',' ;
    }
    if (!file_exists(PLUG_PATH)) {
        mkdir(PLUG_PATH);
        $makeddirs .= PLUG_PATH . ',' ;
    }
    if (!file_exists(SKIN_PATH)) {
        mkdir(SKIN_PATH);
        $makeddirs .= SKIN_PATH . ',' ;
    }
    if (!file_exists(LIB_PATH)) {
        mkdir(LIB_PATH);
        $makeddirs .= LIB_PATH . ',' ;
    }
    if (!file_exists(LIBS_PATH)) {
        mkdir(LIBS_PATH);
        $makeddirs .= LIBS_PATH . ',' ;
    }
    $makeddirs = mb_substr($makeddirs, 0, -1, "UTF-8");
    return $makeddirs;
}

function plugin_convert($html){
    $class = new PluginLoader();
    $html = $class -> pluginConvert($html);
    return $html;
}
?>