<?php
/*--------------------------------
 @id latest_pages
 @name LatestPageList
 @author K
 @copyright 2021-2021 K
 @license GPLv3
--------------------------------*/

define('PLUGIN_LATEST_PAGES_MAX_COUNT', 20);
define('PLUGIN_LATEST_PAGES_HIDEPAGES', 'top'); // 「,」で区切る

class plugin_pluglist
{
    public function convert(){
        $txt = file_get_contents(CACHE_PATH . cache_page_dates_file);
        preg_match_all("/'(.*?)','(.*?)'/u", $txt, $files, PREG_SET_ORDER);
        $hidepages = explode("," ,PLUGIN_LATEST_PAGES_HIDEPAGES);
        $_bloglisthtml = "";
        $count = 0;
        foreach ($files as $file) {
            $time = $file[2];
            $file = ARTICLE_PATH . $file[1];
            $hide_continue = false;
            foreach($hidepages as $hidepage){
                if($hidepage == hex2bin(basename($file))){
                    $hide_continue = true;
                    break;
                }
            }
            if($hide_continue == true){
                continue;
            }
            if(PLUGIN_LATEST_PAGES_MAX_COUNT == $count){
                break;
            }
            ++$count;
            if (is_dir($file)) {
                continue;
            }
            if (file_exists(IMAGE_PATH . "thumbnail/" . basename($file) . ".png")) {
                $_blogimage_path = IMAGE_PATH . "thumbnail/" . basename($file) . ".png";
            } else {
                $_blogimage_path = IMAGE_PATH . "noimage.png";
            }
            $easy_expl = '';
            if (file_exists(ARTICLE_PATH . "expl/" . basename($file))) {
                $easy_expl = file_get_contents(ARTICLE_PATH . "expl/" . basename($file));
            }
            $_bloglisthtml .= '<div id="item"><a href="./?' . hex2bin(basename($file)) . '"></a><div id="item_body"><h3>' . hex2bin(basename($file)) . '</h3><p><strong><img src="' . BASE64_TIME_ICON . '" style="width:12px;height:12px;margin-bottom:-1.25px;" />&nbsp;' . date('Y/m/d', $time) . '</strong></p><div id="image"><img src="' . $_blogimage_path . '" /></div><p>' . $easy_expl . '</p></div></div>';
        }
        $_html = <<<EOD
        <div id="items">
        {$_bloglisthtml}
        </div>
        EOD;
        return $_html;
    }
}
