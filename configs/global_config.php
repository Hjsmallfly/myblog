<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-21
 * Time: 下午9:34
 */

// 服务器设置的网站根目录
//$document_root = $_SERVER["DOCUMENT_ROOT"];
// php文件地址
//var_dump(__FILE__);
// 存放该php文件的目录
//var_dump(realpath( __DIR__ ));

$BLOG_ROOT_DIR = realpath(dirname(__DIR__));
$PHP_SRC_DIR = $BLOG_ROOT_DIR . DIRECTORY_SEPARATOR . "php";

// smarty 相关路径
$SMARTY_TEMPLATES_DIR = $PHP_SRC_DIR .  "/smarty_templates/templates";
$SMARTY_TEMPLATES_C_DIR = $PHP_SRC_DIR  . "/smarty_templates/templates_c";
$SMARTY_CONFIGS_DIR = $PHP_SRC_DIR . "/smarty_templates/configs";
$SMARTY_CACHE_DIR = $PHP_SRC_DIR  . "/smarty_templates/cache";


function get_smarty_instance(){
    global $BLOG_ROOT_DIR, $SMARTY_TEMPLATES_DIR, $SMARTY_TEMPLATES_C_DIR, $SMARTY_CONFIGS_DIR, $SMARTY_CACHE_DIR;
    require_once($BLOG_ROOT_DIR .  "/lib/smarty-3.1.28/libs/Smarty.class.php");
    $smarty = new Smarty();
    $smarty->setTemplateDir($SMARTY_TEMPLATES_DIR);
    $smarty->setCompileDir($SMARTY_TEMPLATES_C_DIR);
    $smarty->setConfigDir($SMARTY_CONFIGS_DIR);
    $smarty->setCacheDir($SMARTY_CACHE_DIR);
    return $smarty;
}



