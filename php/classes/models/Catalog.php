<?php

/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午10:16
 */

/*
 *  define("CATALOG_TABLE", "
    CREATE TABLE IF NOT EXISTS Catalogs(
      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, # 主键
      catalog_tag VARCHAR(20) CHARACTER SET utf8, # 类别名
      post_count INT DEFAULT 0  # 记录当前分类下的文章数量
    )
");
 */

require_once(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "/helpers/error_handler.php");

class Catalog{
    // 常量定义用于查找数据

    const FIELD_CATALOG_NAME = "catalog_tag";
    const FIELD_ID = "id";
    const FIELD_POST_COUNT = "post_count";

    private $db;
    private $id;
    private $catalog_name;
    private $post_count;

    public function __construct($db, $catalog_name){
        $this->db = $db;
        $this->catalog_name = $catalog_name;
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
        $author = static::getCatalogByField($this->db, static::FIELD_CATALOG_NAME, $this->catalog_name);
        if ($author)
            return $author;
        try {
            $stmt = $this->db->prepare("INSERT INTO Catalogs (catalog_tag) VALUES(:catalog_name)");
            $stmt->bindParam(":catalog_name", trim($this->catalog_name));
            $stmt->execute();
//            return $this->db->lastInsertId();
            $this->id = $this->db->lastInsertId();
            $this->post_count = 0;
            return $this->toAssocArray();
        }catch (PDOException $err){
            error_handler($err, "inserting Catalog $this->catalog_name", true);
            return false;
        }

    }

    public static function getCatalogByField($db, $field, $val, $field_type=PDO::PARAM_STR){
        try{
            // PDO 的 prepare 不能绑定字段名
            // 下面这种做法会导致SQL注入的可能性,不过只要对外的接口安全就OK
            $stmt = $db->prepare("SELECT * FROM Catalogs WHERE $field=:val");
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

    public static function modifyPostCount($db, $catalog_id, $negative=false){
//        $db = connect_to_database();
        $catalog = static::getCatalogByField($db, static::FIELD_ID, $catalog_id, PDO::PARAM_INT);
        if ($catalog){
            try {
                $stmt = $db->prepare("UPDATE Catalogs SET post_count=:post_count where id=:id");
                $stmt->bindParam(":id", $catalog_id);
                if (!$negative)
                    $post_count = $catalog["post_count"] + 1;
                else
                    $post_count = $catalog["post_count"] - 1;
                $stmt->bindParam(":post_count", $post_count);
                $stmt->execute();
                return $post_count;
            }catch (PDOException $err){
                error_handler($err, "increasePostCount($catalog_id)", true);
                return false;
            }
        }
    }

    public static function get_all_catalogs($db){
//        $db = connect_to_database();
        try{
            $query = $db->query("SELECT * FROM Catalogs");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $err){
            error_handler($err, "get all catalogs", true);
            return null;
        }
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCatalogName()
    {
        return $this->catalog_name;
    }

    /**
     * @param mixed $catalog_name
     */
    public function setCatalogName($catalog_name)
    {
        $this->catalog_name = $catalog_name;
    }

    /**
     * @return mixed
     */
    public function getPostCount()
    {
        return $this->post_count;
    }

    /**
     * @param mixed $post_count
     */
    public function setPostCount($post_count)
    {
        $this->post_count = $post_count;
    }
}

// testing

//require_once("../connect.php");
//$db = connect_to_database();
//var_dump(Catalog::get_all_catalogs($db));
//$catalog = new Catalog($db, "python");
//$result = $catalog->save();
//$post_count = Catalog::modifyPostCount($db, $result["id"], true);
//var_dump($post_count);
