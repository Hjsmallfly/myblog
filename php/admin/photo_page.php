<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-25
 * Time: 下午3:19
 */
// 如果需要使用session, 记得调用这个函数.
session_start();

require_once($_SERVER["DOCUMENT_ROOT"] . "/php/helpers/scan_files.php");
// 获取所有图片
$PHOTO_FOLDER = $_SERVER["DOCUMENT_ROOT"] . "/img";
$pictures = scandir_by_time($PHOTO_FOLDER, "filectime");
$picture_chunks = array_chunk($pictures, 4);

require_once($_SERVER["DOCUMENT_ROOT"] . "/configs/global_config.php");
$smarty = get_smarty_instance();
$smarty->assign("picture_chunks", $picture_chunks);
$smarty->display("photo_page.tpl");