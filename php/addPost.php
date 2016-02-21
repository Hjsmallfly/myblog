<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 下午8:52
 */
// 开启session
session_start();

require_once("/usr/local/lib/smarty-3.1.28/libs/Smarty.class.php");
require_once("database/connect.php");
require_once("database/classes/Post.php");
require_once("database/classes/Catalog.php");
// debug
//$_SESSION["logged"] = true;

// 没有登陆就跳转到登陆界面
if (!isset($_SESSION["logged"])) {
    // 设置一个session变量用于登陆后的跳转
    $_SESSION["go_to_post_page"] = true;
    header("Location: login.php");
    return;
}

// 处理post请求
if (isset($_POST["title"])){
    if (isset($_POST["post_id"])){
        // 说明是在修改文章内容
    }
    $catalog = mb_strlen($_POST["new_catalog"]) > 0 ? $_POST["new_catalog"] : $_POST["catalog"];
    $db = connect_to_database();
    $post = new Post($db, $_POST["title"], $_POST["content"],
        $_POST["keywords"], $catalog, $_POST["username"]);

    $post_id = $post->save();
//    var_dump($post_info);
    $location_str = "Location: viewpost.php?id=" . $post_id;
//    var_dump($post_id);
    header($location_str);
    return;
}

// 取消跳转变量
unset($_SESSION["go_to_post_page"]);

// 获取数据库连接
$db = connect_to_database();
$smarty = new Smarty();
$catalogs = Catalog::get_all_catalogs($db);
$smarty->assign("catalogs", $catalogs);

// 修改文章内容
if (isset($_GET["id"]) && is_numeric($_GET["id"])){
    $id = intval($_GET["id"]);
    // 获取文章信息
    $post = Post::getPostByField($db, Post::FIELD_ID, $id, PDO::PARAM_INT);
    if ($post){
        $smarty->assign("post", $post);
    }
}

$smarty->display("add_post.tpl");