<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 上午10:27
 */
require_once("/usr/local/lib/smarty-3.1.28/libs/Smarty.class.php");
// 开启session
session_start();

if (isset($_SESSION["logged"]))
    unset($_SESSION["logged"]);
else{
    $_SESSION["logged"] = true;
    $_SESSION["username"] = "hjsmallfly";
}

$smarty = new Smarty();
$smarty->display("navbar.tpl");


