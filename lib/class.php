<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

require(LIB_PATH . "MainLoader.php");
require(LIB_PATH . "Admin.php");
require(LIB_PATH . "Main.php");
require(LIB_PATH . "PluginLoader.php");

global $main_class, $mainloader_class, $pluginloader_class;

if(!isset($main_class)){
    $main_class = new Main();
}
if(!isset($mainloader_class)){
    $mainloader_class = new MainLoader();
}
if(!isset($pluginloader_class)){
    $pluginloader_class = new PluginLoader();
}
