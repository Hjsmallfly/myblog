<?php

/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午1:43
 */


//define("AUTHOR_TABLE", "
//    CREATE TABLE IF NOT EXISTS Authors(
//      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, # 主键
//      author VARCHAR(40) CHARACTER SET utf8,  # 名字
//      website VARCHAR(140) CHARACTER SET utf8 # 主页
//    )
//");
require_once(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "/helpers/error_handler.php");

class Author{

    // 常量定义用于查找数据

    const FIELD_AUTHOR = "author";
    const FIELD_ID = "id";
    const FIELD_WEBSITE = "website";

    private $db;
    private $id;
    private $author;
    private $website;

    public function __construct($db, $author, $website){
        $this->db = $db;
        $this->setAuthor($author);
        $this->setWebsite($website);
    }

    private function toAssocArray(){
        $assocArray = array();
        foreach ($this as $key => $value) {
            if ($key != "db")
                $assocArray[$key] = $value;
        }
        return $assocArray;

    }

    /**
     * 将数据存进数据库中
     * @return bool|mixed
     */
    public function save(){
        $author = static::getAuthorByName($this->db, $this->author);
        if ($author)
            return $author;
        try {
            $stmt = $this->db->prepare("INSERT INTO Authors (author, website) VALUES(:author, :website)");
            $stmt->bindParam(":author", trim($this->author));
            $stmt->bindParam(":website", trim($this->website));
            $stmt->execute();
//            return $this->db->lastInsertId();
            $this->id = $this->db->lastInsertId();
            return $this->toAssocArray();
        }catch (PDOException $err){
            error_handler($err, "inserting Author $this->author", true);
            return false;
        }

    }

    public static function getAuthorByField($db, $field, $val, $field_type=PDO::PARAM_STR){
        try{
            // PDO 的 prepare 不能绑定字段名
            // 下面这种做法会导致SQL注入的可能性,不过只要对外的接口安全就OK
            $stmt = $db->prepare("SELECT * FROM Authors WHERE $field=:val");
//            $stmt->bindParam(":field", $field);
            $stmt->bindParam(":val", $val, $field_type);
            $stmt->execute();
            // 失败返回的是false
            $author = $stmt->fetch(PDO::FETCH_ASSOC);
//            var_dump($stmt->debugDumpParams());
            return $author;
        }catch (PDOException $err){
            error_handler($err, "get Author by [$field] => $val ", true);
            return null;
        }
    }

    /**
     * 获取作者
     * @param $db
     * @param $author_name
     * @return null|false
     */
    public static function getAuthorByName($db, $author_name){
        return static::getAuthorByField($db, static::FIELD_AUTHOR, $author_name);
    }

    public static function getAuthorById($db, $author_id){
        return static::getAuthorByField($db, static::FIELD_ID, $author_id, PDO::PARAM_INT);
    }

    // setter and getters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

}

// testing

//require_once("../connect.php");
//$author = new Author(connect_to_database(), "smallfly3rd", "https://github.com/Hjsmallfly");
//$result = $author->save();
//var_dump($result);
//$db = connect_to_database();
//$author = Author::getAuthorById($db, 1);
//$author = Author::getAuthorByName($db, "smallfly");
//$author = Author::getAuthorByField($db, Author::FIELD_AUTHOR, "smallfly");
//var_dump($author);

// testing