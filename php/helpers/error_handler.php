<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-19
 * Time: 上午12:53
 */



/**
 * @param $err
 * @param $when
 * @param bool|false $display
 */
function error_handler($err, $when, $display=false){
    $error_str = "ERROR OCCURRED WHEN " . $when . ": " . $err->getFile() . " @Line " .
        $err->getLine() . " Message: " . $err->getMessage();
    error_log($error_str);
    if ($display)
        echo json_encode(array("ERROR" => $err->getMessage()));
}

//$tmp = new PDOException("just for testing");
//error_handler($tmp, "testing", true);