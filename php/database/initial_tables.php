<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午1:25
 */

require_once($_SERVER["DOCUMENT_ROOT"] . "/php/helpers/error_handler.php");
require_once("connect.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/classes/models/TableCreator.php");

$db = connect_to_database();

if ($db){
    $creator = new TableCreator($db);
    $tables = [CATALOG_TABLE, AUTHOR_TABLE, POST_TABLE];

    foreach ($tables as $table) {
        $creator->setTableSql($table);
        try{
            $creator->create();
        }catch (PDOException $e){
            error_handler($e, "create table $table", true);
        }
    }

    echo "tables initialized!" . "<br>";
}