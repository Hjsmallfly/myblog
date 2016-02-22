<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 上午10:34
 */
// 开启session
session_start();

require_once("configs/global_config.php");

define("POSTS_PER_PAGE", 10);

$page_num = 1;

if (isset($_GET["p"]) && is_numeric($_GET["p"])){
    $page_num = intval($_GET["p"]);
}

// 获取首页文章信息
require_once("$PHP_SRC_DIR/database/connect.php");
require_once("$PHP_SRC_DIR/classes/models/Post.php");
$db = connect_to_database();

// 默认一页十张
$this_page = Post::get_pagination($db, $page_num, POSTS_PER_PAGE);
Post::toDisplayFormat($this_page);

// 获取所有分类
require_once("$PHP_SRC_DIR/classes/models/Catalog.php");
$catalogs = Catalog::get_all_catalogs($db);

// 处理分页信息

$post_count = Post::getPostCount($db); // 获取总的文章数

if ($post_count == 0)
    $page_count = 1;
elseif ($post_count % POSTS_PER_PAGE == 0)
    $page_count = intval($post_count / POSTS_PER_PAGE );
else
    $page_count = intval($post_count / POSTS_PER_PAGE) + 1;

$page_nums = range(1, $page_count); // rang low, high generates [low, high]

$current_page = $page_num;
$previous_page = ( $current_page == 1 ) ? 1 : ($current_page - 1);
$next_page = ( $current_page == $page_count ) ? $page_count : ($page_num + 1);

$page_info = [
    "nums" => $page_nums,
    "current_page" => $current_page - 1,    // 因为在模板里面 @index 是从零开始的下标
    "previous_page" => $previous_page,
    "next_page" => $next_page
];

//require_once("/usr/local/lib/smarty-3.1.28/libs/Smarty.class.php");
$smarty = get_smarty_instance();
$smarty->assign("lib", $LIBRARY_DIR);
$smarty->assign("php_dir", $PHP_SRC_DIR);
$smarty->assign("page_info", $page_info);
$smarty->assign("post_previews", $this_page);
$smarty->assign("catalog_items", $catalogs);
$smarty->display("index.tpl");
$smarty->display("pagination.tpl");
$smarty->display("footer.tpl");
// 注意 smarty 的display可以多次使用，所以可以不用在一个模板中包含另一个模板