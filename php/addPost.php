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
// debug
$_SESSION["logged"] = true;

if (!isset($_SESSION["logged"]))
    header("Location: login.php");

if (isset($_POST["title"])){
//'title' => string 'An English Poem' (length=15)
//'content' => string '<p>asfd</p>' (length=11)
//'catalog' => string 'c++' (length=3)
//'keywords' => string '' (length=0)
    $db = connect_to_database();
    $post = new Post($db, $_POST["title"], $_POST["content"], $_POST["keywords"], $_POST["catalog"], "smallfly");
    $post_info = $post->save();
    header("Location: viewpost.php?id=" . $post_info["id"]);
}

$smarty = new Smarty();
$catalogs = [
    "c++", "python", "java", "php", "life"
];
$smarty->assign("catalogs", $catalogs);
$smarty->display("add_post.tpl");