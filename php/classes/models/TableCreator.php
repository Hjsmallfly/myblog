<?php

/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午12:46
 */

//require_once("../config/config.php");
//require_once("../connect.php");
require_once(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "/helpers/error_handler.php");

class TableCreator{

    private $db;
    private $table_sql;

    /**
     * 设置要创建的Table的定义
     * @param $table_sql
     */
    public function setTableSql($table_sql){$this->table_sql = $table_sql;}

    public function __construct($db){
        $this->db = $db;
    }

    public function create(){
        $this->db->query($this->table_sql);
    }

}

// testing
/*
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
*/
// testing