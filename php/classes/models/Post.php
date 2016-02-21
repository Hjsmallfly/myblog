<?php

/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午1:41
 */

// 数据库表格的定义
//define("POST_TABLE", "
//    CREATE TABLE IF NOT EXISTS Posts(
//      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, # 主键
//      title VARCHAR(140) CHARACTER SET utf8, # 标题
//      keywords VARCHAR(140) CHARACTER SET utf8, # 用,隔开
//      moment TIMESTAMP, # 发表时间
//      viewed_times INT DEFAULT 0, # 阅读量
//      content TEXT CHARACTER SET utf8,  # 内容
//
//      # 一些外键
//      catalog_id INT NOT NULL,
//      author_id INT NOT NULL,
//
//      FOREIGN KEY (catalog_id) REFERENCES Catalogs(id),
//      FOREIGN KEY (author_id) REFERENCES Authors(id)
//    )
//    "
//);


require_once(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "/helpers/error_handler.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "Author.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "Catalog.php");

class Post{
    // 常量定义
    const FIELD_ID = "id";
    const FIELD_TITLE = "title";
    const FIELD_CONTENT = "content";
    const FIELD_KEYWORDS = "keywords";
    const FIELD_MOMENT = "moment";
    const FIELD_VIEWED_TIMES = "viewed_times";
    const FIELD_CATALOG_ID = "catalog_id";
    const FIELD_AUTHOR_ID = "author_id";

    // properties
    private $db;
    private $id;
    private $title;
    private $content;
    private $keywords;
    private $moment;
    private $viewed_times;
    private $catalog_tag;
    private $catalog_id;
    private $author_name;
    private $author_id;


    public function __construct($db, $title, $content, $keywords, $catalog_name, $author_name, $moment=null){
        $this->db = $db;
        $this->title = $title;
        $this->content = $content;
        $this->keywords = $keywords;
        $this->catalog_tag = $catalog_name;
        $this->author_name = $author_name;
        if ($moment == null){
            $dateTime = new DateTime();
            // http://php.net/manual/en/datetime.settimestamp.php
            $moment = $dateTime->format("Y-m-d H:i:s");
            $this->moment =  $moment;   // timestamp
        }else{
            $this->moment = $moment;
        }
    }

    /**
     * id 用于判断是新文章还是旧文章
     * update_time 在 id 不为空的时候控制是否更新修改的文章的时间戳
     * 返回不为false的时候，返回的是这篇post在数据库中的id
     * @param null $id
     * @param bool $update_time
     * @return bool
     */
    public function save($id = null, $update_time=false){
        $author = new Author($this->db, $this->author_name, null);
        $author_info = $author->save();
//        var_dump($author_info);
        if (!$author_info)
            return false;
        $catalog = new Catalog($this->db, $this->catalog_tag);
        $catalog_info = $catalog->save();
//        var_dump($catalog_info);
        if (!$catalog_info)
            return false;
        try{
            if ($id != null){
                $post = Post::getPostByField($this->db, static::FIELD_ID, $id, PDO::PARAM_INT);
                if (!$post)
                    return false;
//                $this->db = connect_to_database();
                // 注意 执行 UPDATE 的时候一定要记得带上 WHERE 条件， 不然会全部都改掉!
                $stmt = $this->db->prepare("UPDATE Posts SET title=:title, keywords=:keywords,
moment=:moment, content=:content, catalog_tag=:catalog_tag, author=:author, catalog_id=:c_id,
author_id=:a_id WHERE id=$id");
                // 时间戳
                if (!$update_time){
                    $this->moment = $post["moment"];    // 使用之前的时间戳
                }
                // 分类
                if ($this->catalog_tag != $post["catalog_tag"]){
                    // 减少原来的分类里面的Post数量
                    Catalog::modifyPostCount($this->db, $post["catalog_id"], true);
                    // 增加新增的分类里面的Post数量
                    Catalog::modifyPostCount($this->db, $catalog_info["id"]);
                }

            }else{
                // 增加计数
                Catalog::modifyPostCount($this->db, $catalog_info["id"]);
                $stmt =
                    $this->db->prepare("INSERT INTO Posts
                  (title, keywords, moment, content, catalog_tag, author, catalog_id, author_id)
                  VALUES (:title, :keywords, :moment, :content, :catalog_tag, :author, :c_id, :a_id)");
            }
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":keywords", $this->keywords);
            $stmt->bindParam(":moment", $this->moment);
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":catalog_tag", $this->catalog_tag);
            $stmt->bindParam(":author", $this->author_name);
            $c_id = $catalog_info["id"];
//            var_dump($c_id);
            $stmt->bindParam(":c_id", $c_id, PDO::PARAM_INT);
            $a_id = $author_info["id"];
            $stmt->bindParam(":a_id", $a_id, PDO::PARAM_INT);
            $stmt->execute();
            if ($id != null){
                $this->id = $id;
            }else
                $this->id = $this->db->lastInsertId();
            return $this->id;
        }catch (PDOException $err){
            error_handler($err, "inserting Post( $this->title )", true);
            return false;
        }

    }

    public static function toDisplayFormat(&$posts, $preview_length=200, $preview_tail="..."){
        // 处理一些信息
        for($i = 0 ; $i < count($posts) ; ++$i){
            if (mb_strstr($posts[$i]["keywords"], ";"))
                $posts[$i]["keywords"] = explode(";", $posts[$i]["keywords"]);
            else
                $posts[$i]["keywords"] = array($posts[$i]["keywords"]);
            $posts[$i]["content"] =
                static::extract_content($posts[$i]["content"], $preview_length, $preview_tail);

            // 不显示具体的时间
            $timestamp = strtotime($posts[$i]["moment"]);
            $posts[$i]["moment"] = date("Y/m/d", $timestamp);
        }
    }

    public static function get_pagination($db, $page_num, $page_size){
//        $db = connect_to_database();
        // 注意两个地方都需要用相同的方式排序,不然可能造成结果的不一致
        $stmt = $db->prepare("SELECT * FROM (SELECT id FROM Posts ORDER BY moment DESC, id DESC LIMIT :page_size OFFSET :offset) AS lt INNER JOIN
                          Posts ON lt.id = Posts.id ORDER BY Posts.moment DESC, Posts.id DESC");
        // 计算offset, 数据库里面的offset是从0开始
        $offset = ( $page_num - 1 ) * $page_size;
        $stmt->bindParam(":page_size", $page_size, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        try{
            $stmt->execute();
            // 如果没有内容返回的是空数组
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch (PDOException $e){
            error_handler($e, "get_pagination", true);
            return null;
        }
    }

    public static function extract_content($content, $length=200, $tail="..."){
        $content = strip_tags($content);
        if (mb_strlen($content) <= $length)
            return $content;
        return mb_substr($content, 0, $length) . $tail;
    }
    public static function getPostByField($db, $field, $val, $field_type=PDO::PARAM_STR){
        try{
            // PDO 的 prepare 不能绑定字段名
            // 下面这种做法会导致SQL注入的可能性,不过只要对外的接口安全就OK
            $stmt = $db->prepare("SELECT * FROM Posts WHERE $field=:val");
//            $stmt->bindParam(":field", $field);
            $stmt->bindParam(":val", $val, $field_type);
            $stmt->execute();
            // 失败返回的是false
            $post = $stmt->fetch(PDO::FETCH_ASSOC);
//            var_dump($stmt->debugDumpParams());
            return $post;
        }catch (PDOException $err){
            error_handler($err, "get Post by [$field] => $val ", true);
            return null;
        }
    }

    public static function getPostCount($db){
//        $db = connect_to_database();
        try{
            $result = $db->query("SELECT COUNT(id) as post_count FROM Posts");
            $post_count = $result->fetch(PDO::FETCH_ASSOC)["post_count"];
            return intval( $post_count );

        }catch(PDOException $err){
            error_handler($err, "query post count", true);
            return null;
        }
    }

    public static function modifyPostCount($db, $post_id, $negative=false){
//        $db = connect_to_database();
        $post = static::getPostByField($db, static::FIELD_ID, $post_id, PDO::PARAM_INT);
        if ($post){
            try {
                $stmt = $db->prepare("UPDATE Posts SET viewed_times=:viewed_times where id=:id");
                $stmt->bindParam(":id", $post_id);
                if (!$negative)
                    $viewed_times = $post["viewed_times"] + 1;
                else
                    $viewed_times = $post["viewed_times"] - 1;
                $stmt->bindParam(":viewed_times", $viewed_times);
                $stmt->execute();
                return $viewed_times;
            }catch (PDOException $err){
                error_handler($err, "increaseViewedTimes($post_id)", true);
                return false;
            }
        }
    }


    public static function delete_post($db, $post_id, $username){
        // $username 用于 验证 该用户是否有权力删除这篇post
        $post = self::getPostByField($db, static::FIELD_ID, $post_id, PDO::PARAM_INT);
        if (!$post)
            return json_encode(["ERROR" => "no such post"]);
//        if ($post["author"] != $username)
//            return json_encode(["ERROR" => "not allowed"]);
        try {
            $stmt = $db->prepare("DELETE FROM Posts WHERE id=:post_id");
            $stmt->bindParam(":post_id", $post_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                Catalog::modifyPostCount($db, $post["catalog_id"], true);
                return true;
            } else {
                return false;
            }
        }catch(PDOException $err){
            error_handler($err, "deleting post[$post_id]", true);
            return false;
        }
    }

    // getters and setters

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return mixed
     */
    public function getMoment()
    {
        return $this->moment;
    }

    /**
     * @param mixed $moment
     */
    public function setMoment($moment)
    {
        $this->moment = $moment;
    }

    /**
     * @return mixed
     */
    public function getViewedTimes()
    {
        return $this->viewed_times;
    }

    /**
     * @param mixed $viewed_times
     */
    public function setViewedTimes($viewed_times)
    {
        $this->viewed_times = $viewed_times;
    }

    /**
     * @return mixed
     */
    public function getCatalogId()
    {
        return $this->catalog_id;
    }

    /**
     * @param mixed $catalog_id
     */
    public function setCatalogId($catalog_id)
    {
        $this->catalog_id = $catalog_id;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }

}

//require_once("../connect.php");
//$db = connect_to_database();
//$post = new Post($db, "First Post", "Hello world", "hello;world", "test", "smallfly", null);
//$p_id = $post->save();
//var_dump($p_id);
//
//$page1 = Post::get_pagination($db, 1, 2);
//$page2 = Post::get_pagination($db, 2, 2);
//
//echo "page1: " . "<br>";
//var_dump($page1);
//echo "page2: " . "<br>";
//var_dump($page2);

//$post = new Post(null, null, "1234", null, null);
//
//var_dump(Post::extract_content($post->getContent(), 4));
