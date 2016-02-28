<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-27
 * Time: 下午9:54
 */
// 启动session
session_start();


// 检查参数
if (!isset($_GET["keyword"])){
    header("Location: /index.php");
    return;
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/php/database/connect.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/classes/models/Post.php");
$db = connect_to_database();
$posts = Post::search_by_keyword($db, $_GET["keyword"]);
Post::toPreviewFormat($posts);

// 获取所有分类
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/classes/models/Catalog.php");
$catalogs = Catalog::get_all_catalogs($db);

require_once($_SERVER["DOCUMENT_ROOT"] . "/configs/global_config.php");
$smarty = get_smarty_instance();
$smarty->assign("post_previews", $posts);
$smarty->assign("catalog_items", $catalogs);
$smarty->display("index.tpl");
$smarty->display("footer.tpl");