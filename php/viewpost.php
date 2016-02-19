<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 下午1:11
 */

// 开启session
session_start();

// debug
//$_GET["id"] = 1;

// 检查参数
if (!isset($_GET["id"])){
    header("Location: index.php");
}

$id = $_GET["id"];
if (!is_numeric($id))
    header("Location: index.php");

$id = intval($id);

require_once("database/connect.php");
require_once("database/classes/Post.php");
$db = connect_to_database();
$post = Post::getPostByField($db, Post::FIELD_ID, $id, PDO::PARAM_INT);

// 把keywords分割为数组
$post["keywords"] = explode(";", $post["keywords"]);
require_once("/usr/local/lib/smarty-3.1.28/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("post", $post);
$smarty->display("view_post.tpl");