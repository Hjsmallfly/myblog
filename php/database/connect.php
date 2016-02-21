<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午12:10
 */

// 连接数据库

require_once(__DIR__ . "/config/config.php");
require_once(dirname(__DIR__) . "/helpers/error_handler.php");

function connect_to_database(){
    global $USERNAME, $PASSWORD;
    try {
        // 第一个参数是描述不同数据库的
        $db = new PDO("mysql:hostname=localhost;dbname=" . DATABASE_NAME . ";charset=utf8", $USERNAME, $PASSWORD);
        // 可以设置属性
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }catch (PDOException $err){
//    echo "ERROR: " . $err->getMessage();
//    error_log("ERROR WHILE CONNECT TO DATABASE: " . $err->getMessage());
        error_handler($err, "CONNECTING TO DATABASE", true);
        $db = null;
        return $db;
    }
}

