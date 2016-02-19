<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 下午11:55
 */

define("AUTHENTICATION_FILE", "authentication_file.txt");
define("DATABASE_NAME", "blog");


$AUTHENTICATION_FILE_PATH = __DIR__ . DIRECTORY_SEPARATOR . AUTHENTICATION_FILE;

function get_authentication_info($filename){
    if (!file_exists($filename))
        return false;
    return json_decode(file_get_contents($filename), true);
}

$info = get_authentication_info($AUTHENTICATION_FILE_PATH);

if ($info) {
    $USERNAME = $info["username"];
    $PASSWORD = $info["password"];
}else{
    $USERNAME = null;
    $PASSWORD = null;
}

define("CATALOG_TABLE", "
    CREATE TABLE IF NOT EXISTS Catalogs(
      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, # 主键
      catalog_tag VARCHAR(20) CHARACTER SET utf8, # 类别名
      post_count INT DEFAULT 0  # 记录当前分类下的文章数量
    )
");

define("AUTHOR_TABLE", "
    CREATE TABLE IF NOT EXISTS Authors(
      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, # 主键
      author VARCHAR(40) CHARACTER SET utf8,  # 名字
      website VARCHAR(140) CHARACTER SET utf8 # 主页
    )
");

// 数据库表格的定义
define("POST_TABLE", "
    CREATE TABLE IF NOT EXISTS Posts(
      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, # 主键
      title VARCHAR(140) CHARACTER SET utf8, # 标题
      keywords VARCHAR(140) CHARACTER SET utf8, # 用,隔开
      moment TIMESTAMP DEFAULT CURRENT_TIMESTAMP , # 发表时间(加个default是防止 ON UPDATE CURRENT_TIMESTAMP )
      viewed_times INT DEFAULT 0, # 阅读量
      content TEXT CHARACTER SET utf8,  # 内容
      author VARCHAR(40) CHARACTER SET utf8,  # 作者名
      catalog_tag VARCHAR(20) CHARACTER SET utf8, # 类别名
      # 一些外键
      catalog_id INT NOT NULL,
      author_id INT NOT NULL,

      FOREIGN KEY (catalog_id) REFERENCES Catalogs(id),
      FOREIGN KEY (author_id) REFERENCES Authors(id)
    )
    "
);