<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

class PluginLoader
{
    public function pluginConvert($data)
    {
        preg_match_all('/\$([a-z0-9\-_]*?);/i', $data, $plugins, PREG_SET_ORDER);
        foreach ($plugins as $plugin) {
            if (file_exists(PLUG_PATH . mb_strtolower($plugin[1]) . ".php")) {
                include_once(PLUG_PATH . mb_strtolower($plugin[1]) . ".php");
                if (class_exists("plugin_" . mb_strtolower($plugin[1]))) {
                    $plugin_class_name = "plugin_" . mb_strtolower($plugin[1]);
                    $plugin_class = new $plugin_class_name;
                    if (method_exists($plugin_class, "convert")) {
                        $result = call_user_func(array($plugin_class, 'convert'));
                        $data = preg_replace('/\$' . $plugin[1] . ";/", $result, $data, 1);
                    }
                }
            }
        }
        return $data;
    }
}
