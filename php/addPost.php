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

if (!isset($_SESSION["logged"]))
    header("Location: login.php");

if (isset($_POST["title"])){
    $db = connect_to_database();
    $post = new Post($db, $_POST["title"], $_POST["content"], $_POST["keywords"], $_POST["catalog"], "smallfly");
    $post_info = $post->save();
    header("Location: viewpost.php?id=" . $post_info["id"]);
}

$db = connect_to_database();

$smarty = new Smarty();
$catalogs = Catalog::get_all_catalogs($db);
//var_dump($catalogs);
$smarty->assign("catalogs", $catalogs);
$smarty->display("add_post.tpl");