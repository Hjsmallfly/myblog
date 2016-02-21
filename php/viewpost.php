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

if (!$post) { // 没有这篇文件的话
    header("Location: index.php");
    return;
}
// 修改浏览次数
Post::modifyPostCount($db, $post["id"]);

// 把keywords分割为数组
$post["keywords"] = explode(";", $post["keywords"]);
require_once("/usr/local/lib/smarty-3.1.28/libs/Smarty.class.php");
$smarty = new Smarty();

$smarty->assign("post", $post);
//// 生成静态文件(也可以用smarty的fetch方法来获取模板的内容)
//ob_start();
//    $smarty->display("view_post.tpl");
//    $page_content = ob_get_contents();
//ob_end_clean();
//// 生成静态文件
//var_dump($page_content);
//file_put_contents("../archive" . DIRECTORY_SEPARATOR . $post["id"] . ".html", $page_content);
//
$smarty->display("view_post.tpl");