<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 上午10:34
 */
// 开启session
session_start();

define("POSTS_PER_PAGE", 2);

$page_num = 1;
if (isset($_GET["p"]) && is_numeric($_GET["p"])){
    $page_num = intval($_GET["p"]);
}

// 获取首页文章信息
require_once("database/connect.php");
require_once("database/classes/Post.php");
$db = connect_to_database();

// 默认一页十张
$page = Post::get_pagination($db, $page_num, POSTS_PER_PAGE);
// 获取总的文章数

$post_count = Post::getPostCount($db);

// 处理一些信息
for($i = 0 ; $i < count($page) ; ++$i){
    if (mb_strstr($page[$i]["keywords"], ";"))
        $page[$i]["keywords"] = explode(";", $page[$i]["keywords"]);
    else
        $page[$i]["keywords"] = array($page[$i]["keywords"]);
    $page[$i]["content"] = Post::extract_content($page[$i]["content"], 200);

    // 不显示具体的时间
    $timestamp = strtotime($page[$i]["moment"]);
    $page[$i]["moment"] = date("Y/m/d", $timestamp);
}

$catalogs = [
    [
        "name" => "c++",
        "count" => 99,
        "url" => "http://localhost"
    ],
    [
        "name" => "java",
        "count" => 99,
        "url" => "http://localhost"
    ],
];

$pages = range(1, ( $post_count / POSTS_PER_PAGE) + 1);
//var_dump($post_count);

require_once("/usr/local/lib/smarty-3.1.28/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->assign("pages", $pages);
$smarty->assign("post_previews", $page);
$smarty->assign("catalog_items", $catalogs);
$smarty->display("index.tpl");