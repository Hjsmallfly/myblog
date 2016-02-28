<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-22
 * Time: 下午8:02
 */
// 开启session
session_start();
//debug
//$_GET["tag_id"] = 2;

// 检查参数
if (!isset($_GET["tag_id"]) || !is_numeric($_GET["tag_id"])){
    header("Location: /index.php");
    return;
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/php/database/connect.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/classes/models/Post.php");
$db = connect_to_database();
$posts = Post::getPostByField($db, Post::FIELD_CATALOG_ID, intval($_GET["tag_id"]), PDO::PARAM_INT);

Post::toPreviewFormat($posts);

// 获取所有分类
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/classes/models/Catalog.php");
$catalogs = Catalog::get_all_catalogs($db);

//require_once("/usr/local/lib/smarty-3.1.28/libs/Smarty.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/configs/global_config.php");
$smarty = get_smarty_instance();
$smarty->assign("post_previews", $posts);
$smarty->assign("catalog_items", $catalogs);
$smarty->display("index.tpl");
$smarty->display("footer.tpl");