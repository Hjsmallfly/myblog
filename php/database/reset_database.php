<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午1:35
 */

/**
 * @param $msg
 * @param bool|true $line_break
 */
function echoln($msg, $line_break=true){
    $msg = $line_break ? $msg . "<br>" : $msg ;
    echo $msg;
}
require_once("config/config.php");
require_once("connect.php");
$db = connect_to_database();

echoln("drop database");
$db->exec("DROP DATABASE " . DATABASE_NAME);
echoln("create database");
$db->exec("CREATE DATABASE " . DATABASE_NAME . "; USE " . DATABASE_NAME);

echoln("create tables");
require_once("initial_tables.php");
echoln("reset!");