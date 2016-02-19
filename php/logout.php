<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-18
 * Time: 下午9:55
 */
session_start();
unset($_SESSION["logged"]);
header("Location: index.php");