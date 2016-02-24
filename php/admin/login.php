<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 下午10:06
 */
// 开启session
session_start();
// 暂时先简单记录一下登陆
define("USER_FILE", "user.txt");

$filename = __DIR__ . DIRECTORY_SEPARATOR . USER_FILE;
$user_obj = json_decode(file_get_contents($filename), true);

function login(){
    global $user_obj;
    // 清理工作
    if (isset($_SESSION["failed"]))
        unset($_SESSION["failed"]);

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ( $_POST["username"] == $user_obj["username"] && $_POST["password"] == $user_obj["password"] ) {
            $_SESSION["logged"] = true;
            $_SESSION["username"] = $_POST["username"];
            if (isset($_SESSION["go_to_post_page"])) {
                header("Location: /php/admin/addPost.php");
                return;
            }
            else {
                header("Location: /index.php");
                return;
            }
        } else {
            $_SESSION["failed"] = true;
            return;
        }
    }elseif(isset($_SESSION["logged"])){
        header("Location: /index.php");
        return;
    }
}

login();

require_once($_SERVER["DOCUMENT_ROOT"] . "/configs/global_config.php");
//$smarty = new Smarty();
$smarty = get_smarty_instance();
//$smarty->display("navbar.tpl");
$smarty->display("login.tpl");