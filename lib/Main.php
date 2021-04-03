<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

class Main
{
    public $uri;
    public function __construct()
    {
        if (empty($this->uri)) {
            $this->uri = $_SERVER['REQUEST_URI'];
        }
    }

    public function createUrlVars()
    {
        global $url_var;
        if (empty($_POST)) {
            $url_var = &$_GET;
        } elseif (empty($_GET)) {
            $url_var = &$_POST;
        } else {
            $url_var = array_merge($_GET, $_POST);
        }
        $GLOBALS['url_var'] = $url_var;
    }

    public function do()
    {
        global $url_var, $lang;
        if (!isset($url_var)) {
            $url_var = $GLOBALS['url_var'];
        }
        if ($url_var['do'] == 'admin_edit') {
            $admin = new Admin();
            if ($admin->auth($_SESSION['admin_pass'])) {
                if (isset($url_var['article_save'])) {
                    file_put_contents(ARTICLE_PATH . bin2hex($url_var['page']), $url_var['article_edit']);
                    cache_page_dates($url_var['page']);
                    if (isset($url_var['easy_expl'])) {
                        if (!file_exists(ARTICLE_PATH . "expl")) {
                            mkdir(ARTICLE_PATH . "expl");
                        }
                        file_put_contents(ARTICLE_PATH . "expl/" . bin2hex($url_var['page']), $url_var['easy_expl']);
                    }
                    return $url_var['article_edit'];
                }
            }
        } elseif ($url_var['do'] == 'search') {
            $_html = '';
            if (!isset($url_var['search_var'])) {
                $_html = <<<EOD
                <h3>{$lang['search_articles']}</h3>
                <div id="search">
                    <form method="GET">
                        <div style="border:1px solid rgb(150, 150, 150);outline:none;margin:0 auto;width:90%;height:30px;background-color:white;" id="search_box">
                            <input type="hidden" name="do" value="search" />
                            <input type="text" name="search_var" placeholder="{$lang['search_articles_placeholder']}" size="15" style="border:none;outline:none;width:100%;height:100%;background-color:transparent;" />
                        </div>
                        <div id="search_line"></div>
                        <span id="search_btn">
                            <input type="submit" value="{$lang['search']}" style="border:none;outline:none;margin:-26px 5% 0 auto;display:block;background-color:transparent;cursor:pointer;color:rgb(30, 30, 180);" />
                        </span>
                    </form>
                </div>
                EOD;
            } else {
                $search_var = $url_var['search_var'];
                $search_var = preg_quote($search_var, '/');
                $search_var = str_replace("\(", '__parenthesis__', $search_var);
                $search_var = str_replace("\)", '__parenthesis2__', $search_var);
                $search_var = preg_replace('/(.*?)\s/', '(?=.*$1)', $search_var);
                $search_var = preg_replace('/([^\)\(]+?)$/', '(?=.*$1)', $search_var, 1);
                $search_var = str_replace('__parenthesis__', '\\(', $search_var);
                $search_var = str_replace('__parenthesis2__', '\\)', $search_var);
                $_result = '';
                $files = glob("./" . ARTICLE_PATH . "*");
                foreach ($files as $file) {
                    if (is_dir($file)) {
                        continue;
                    }
                    $easy_expl = '';
                    if (file_exists(ARTICLE_PATH . "expl/" . basename($file))) {
                        $easy_expl = file_get_contents(ARTICLE_PATH . "expl/" . basename($file));
                    }
                    $source = file_get_contents($file);
                    $source = preg_replace_callback('/\$([a-z0-9\-_]*?);/i', function ($plugin) {
                        if (file_exists(PLUG_PATH . mb_strtolower($plugin[1]) . ".php")) {
                            include_once(PLUG_PATH . mb_strtolower($plugin[1]) . ".php");
                            if (class_exists("plugin_" . mb_strtolower($plugin[1]))) {
                                $plugin_class_name = "plugin_" . mb_strtolower($plugin[1]);
                                $plugin_class = new $plugin_class_name;
                                if (method_exists($plugin_class, "convert")) {
                                    return "";
                                }
                            }
                        }
                        return $plugin[0];
                    }, $source);
                    if(!preg_match('/' . $search_var . '/i', hex2bin(basename($file)) . $easy_expl . strip_tags($source))){
                        continue;
                    }
                    if (file_exists(IMAGE_PATH . "thumbnail/" . basename($file) . ".png")) {
                        $_blogimage_path = IMAGE_PATH . "thumbnail/" . basename($file) . ".png";
                    } else {
                        $_blogimage_path = IMAGE_PATH . "noimage.png";
                    }
                    $_result .= '<div id="item" style="width:100%;"><a href="./?' . hex2bin(basename($file)) . '"></a><div id="item_body"><h3>' . hex2bin(basename($file)) . '</h3><p><strong><img src="' . BASE64_TIME_ICON . '" style="width:12px;height:12px;margin-bottom:-1.25px;" />&nbsp;' . date('Y/m/d', filemtime($file)) . '</strong></p><div id="image"><img src="' . $_blogimage_path . '" /></div><p>' . $easy_expl . '</p></div></div>';
                }
                $_html = <<<EOD
                <h3>{$lang['search_articles']}</h3>
                <div id="search">
                    <form method="GET">
                        <div style="border:1px solid rgb(150, 150, 150);outline:none;margin:0 auto;width:90%;height:30px;background-color:white;" id="search_box">
                            <input type="hidden" name="do" value="search" />
                            <input type="text" name="search_var" placeholder="{$lang['search_articles_placeholder']}" size="15" style="border:none;outline:none;width:100%;height:100%;background-color:transparent;" value="{$url_var['search_var']}" />
                        </div>
                        <div id="search_line"></div>
                        <span id="search_btn">
                            <input type="submit" value="{$lang['search']}" style="border:none;outline:none;margin:-26px 5% 0 auto;display:block;background-color:transparent;cursor:pointer;color:rgb(30, 30, 180);" />
                        </span>
                    </form>
                </div>
                <div id="items">
                {$_result}
                </div>
                EOD;
            }
            return $_html;
        } elseif ($url_var['do'] == 'admin') {
            $_htmltag = "";
            $admin = new Admin();
            if (isset($url_var['admin_pass'])) {
                if ($admin->auth($url_var['admin_pass']) == true) {
                    $_SESSION['admin_pass'] = $url_var['admin_pass'];
                }
            }

            if ($admin->auth($_SESSION['admin_pass'])) {
                if (isset($url_var['page'])) {
                    $easy_expl = "";
                    $page_contents = "";
                    if (file_exists(ARTICLE_PATH . "expl/" . bin2hex($url_var['page']))) {
                        $easy_expl = file_get_contents(ARTICLE_PATH . "expl/" . bin2hex($url_var['page']));
                    }
                    if (file_exists(ARTICLE_PATH . bin2hex($url_var['page']))) {
                        $page_contents = file_get_contents(ARTICLE_PATH . bin2hex($url_var['page']));
                    }
                    global $head_elements;
                    $head_elements[] = '<script src="' . LIBS_PATH . 'ckeditor/ckeditor.js"></script>';
                    $_html = <<<EOD
                    <h2>{$lang["edit_article"]}</h2>
                    <form method="post" action="?{$url_var['page']}">
                        <input type="hidden" name="do" value="admin_edit">
                        <input type="hidden" name="page" value="{$url_var['page']}">
                        <textarea style="width:100%;height:500px;" name="article_edit">{$page_contents}</textarea>
                        <br />
                        <input type="submit" name="article_save" value="保存"> <input type="text" size="75" name="easy_expl" value="{$easy_expl}" placeholder="簡易説明">
                    </form>
                    <script>
                        CKEDITOR.replace('article_edit');
                    </script>
                    EOD;
                }
                return $_html;
            }

            if (isset($url_var['page'])) {
                $_htmltag = "<input name=\"page\" type=\"hidden\" value=\"" . $url_var['page'] . "\" />";
            }
            $_html = <<<EOD
            <h2>{$lang['admin_auth']}</h2>
            <form method="POST" action="?do=admin">
            <input name="do" type="hidden" value="admin" />
            {$_htmltag}
            <input name="admin_pass" type="password" />
            <input type="submit" value="{$lang['login_submit']}" />
            </form>
            EOD;
            return $_html;
        }
    }

    public function getPageName()
    {
        global $url_var, $do;
        if (!isset($url_var['page'])) {
            if (!isset($url_var['do'])) {
                $url_var['do'] = $do = 'show';
                if (preg_match("/.*?\?(.*)/", $this->uri, $matches)) {
                    $matches = explode("&", $matches[1]);
                    foreach ($matches as $value) {
                        if (!preg_match("/=/", $value)) {
                            $url_var['page'] = urldecode($value);
                            break;
                        } else {
                            $url_var['page'] = "top";
                        }
                    }
                } else {
                    $url_var['page'] = "top";
                }
            }
        }
        if (empty($url_var['page'])) {
            $url_var['page'] = "top";
        }
        return $url_var['page'];
    }

    public function getLoadedPage()
    {
        global $contents_data;
        return $contents_data;
    }

    public function getPage($pagename)
    {
        $MainLoader = new MainLoader();
        $pagedata = $MainLoader->pageLoader($pagename);
        return $pagedata;
    }

    public function getUrl()
    {
        $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $urlarray = explode("/", $url);
        $dir = "";
        for ($i = 0; $i < count($urlarray) - 1; $i++) {
            $dir .= $urlarray[$i] . "/";
        }
        return $dir;
    }
}
