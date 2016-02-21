<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-21
 * Time: 下午3:12
 */

session_start();

require_once("database/connect.php");
require_once("database/classes/Post.php");

// 检查登陆状态

if (!isset($_SESSION["logged"])){
    echo json_encode(["ERROR" => "not allowed(not logged in)"]);
    return;
}

// 检查参数

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    echo json_encode(["ERROR" => "invalid parameter"]);
    return;
}

$db = connect_to_database();
$flag = Post::delete_post($db, $_GET["id"], $_SESSION["username"]);
if ($flag === true){
    echo json_encode(["status" => "deleted"]);
}else{
    echo $flag;
}