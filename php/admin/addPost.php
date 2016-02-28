<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 下午8:52
 */
// 开启session
session_start();



require_once($_SERVER["DOCUMENT_ROOT"] .  "/php/database/connect.php");
require_once($_SERVER["DOCUMENT_ROOT"] .  "/php/classes/models/Post.php");
require_once($_SERVER["DOCUMENT_ROOT"] .  "/php/classes/models/Catalog.php");
// debug
//$_SESSION["logged"] = true;

// 没有登陆就跳转到登陆界面
if (!isset($_SESSION["logged"])) {
    header("Location: login.php?location=" . $_SERVER["REQUEST_URI"]);
    return;
}

// 处理post请求
if (isset($_POST["title"])){
    $id = null;
    if (isset($_POST["post_id"])){
        // 说明是在修改文章内容
        $id = intval($_POST["post_id"]);
    }
    $catalog = mb_strlen($_POST["new_catalog"]) > 0 ? $_POST["new_catalog"] : $_POST["catalog"];
    $db = connect_to_database();
    // escape title
    $title = htmlspecialchars($_POST["title"]);
    $content = $_POST["content"];
    if (mb_strstr($content, "<pre")){
        // 将 pre tag 里面的<br />替换成 \n
        $pattern = "#<br\s*\/>(?=(?:(?!<\/?pre>)[\s\S])*<\/pre>)#";
        // 内容太长的话 preg_replace会导致php解释器崩溃, 目前还没有找到合适办法
        $content = preg_replace($pattern, "\n", $_POST["content"]);
    }
    $post = new Post($db, $title, $content,
        $_POST["keywords"], $catalog, $_POST["username"]);

    $post_id = $post->save($id);
//    var_dump($post_info);
    $location_str = "Location: /php/views/viewpost.php?id=" . $post_id;
//    var_dump($post_id);
    header($location_str);
    return;
}

// 取消跳转变量
unset($_SESSION["go_to_post_page"]);

require_once($_SERVER["DOCUMENT_ROOT"] . "/configs/global_config.php");
// 获取数据库连接
$db = connect_to_database();
$smarty = get_smarty_instance();
$catalogs = Catalog::get_all_catalogs($db);
$smarty->assign("catalogs", $catalogs);

// 修改文章内容
if (isset($_GET["id"]) && is_numeric($_GET["id"])){
    $id = intval($_GET["id"]);
    // 获取文章信息
    $posts = Post::getPostByField($db, Post::FIELD_ID, $id, PDO::PARAM_INT);
    if ($posts){
        $post = $posts[0];
        $smarty->assign("post", $post);
    }
}

//$smarty->display("navbar.tpl");
$smarty->display("add_post.tpl");