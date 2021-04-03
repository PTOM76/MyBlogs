<?php
/*--------------------------------
 @id leftmenu
 @name LeftMenuBar
 @author K
 @copyright 2021-2021 K
 @license GPLv3
--------------------------------*/

define('PLUGIN_LEFTMENU_MAX_COUNT', 5);
define('PLUGIN_LEFTMENU_HIDEPAGES', 'top'); // 「,」で区切る

class plugin_leftmenu
{
    public function convert(){
        global $lang;
        $txt = file_get_contents(CACHE_PATH . cache_page_dates_file);
        preg_match_all("/'(.*?)','(.*?)'/u", $txt, $files, PREG_SET_ORDER);
        $hidepages = explode(",", PLUGIN_LEFTMENU_HIDEPAGES);
        $_bloglisthtml = "";
        $count = 0;
        foreach ($files as $file) {
            $file = ARTICLE_PATH . $file[1];
            $hide_continue = false;
            foreach ($hidepages as $hidepage) {
                if ($hidepage == hex2bin(basename($file))) {
                    $hide_continue = true;
                    break;
                }
            }
            if ($hide_continue == true) {
                continue;
            }
            if (PLUGIN_LEFTMENU_MAX_COUNT == $count) {
                break;
            }
            ++$count;
            if(is_dir($file)){
                continue;
            }
            if (file_exists(IMAGE_PATH . "thumbnail/" . basename($file) . ".png")) {
                $_blogimage_path = IMAGE_PATH . "thumbnail/" . basename($file) . ".png";
            } else {
                $_blogimage_path = IMAGE_PATH . "noimage.png";
            }
            $_bloglisthtml .= '<div id="menu_item"><a href="./?' . hex2bin(basename($file)) . '"></a><div id="menu_item_body"><div id="image"><img src="' . $_blogimage_path . '" /></div><p>' . hex2bin(basename($file)) . '</p></div></div><hr />';
        }
        return <<<EOD
        <h3>{$lang['search_articles']}</h3>
        <div id="search">
        <form method="GET">
            <input type="hidden" name="do" value="search" />
            <input type="text" name="search_var" placeholder="{$lang['search_articles_placeholder']}" size="15" />
            <input type="submit" value="{$lang['search']}" />
        </form>
        </div>
        <h3>{$lang['latest_articles']}</h3>
        <div id="latest_page">
            {$_bloglisthtml}
        </div>
        EOD;
    }
}
