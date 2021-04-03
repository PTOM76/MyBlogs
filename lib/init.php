<?php
/*--------------------------------
 @name MyBlogs
 @author K
 @copyright 2020-2021 K
 @license GPLv3
--------------------------------*/

global $head_elements, $url_var, $do;
$head_elements = array();
$url_var = array();

session_start();

// Debug:Auto reload
//$head_elements[] = '<meta http-equiv="refresh" content="3; URL=">';

require_once("config.ini.php");
require_once(LIB_PATH . "vars.php");
require_once(LIB_PATH . "func.php");
require_once(LIB_PATH . "class.php");
require_once(LIB_PATH . "config.php");

makedirs();

?>