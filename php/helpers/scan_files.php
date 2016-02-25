<?php
/**
 * Created by PhpStorm.
 * User: smallfly
 * Date: 16-2-10
 * Time: 上午11:29
 */

/**
 * @param $root_folder
 * @param string $time_func
 * @param array $ignore
 * @return array|bool
 */
function scandir_by_time($root_folder, $time_func="filemtime", $accept=["jgeg", "jpg", "png", "gif"], $ignore=[".", ".."]){
    if (!file_exists($root_folder))
        return false;
    $files = array();
    foreach(scandir($root_folder) as $file){
        if (in_array($file, $ignore))
            continue;
        // PATH_SEPARATOR is not DIRECTORY_SEPARATOR
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if (!in_array($extension, $accept))
            continue;
        $file_path = $root_folder . DIRECTORY_SEPARATOR . $file;
        $files[$file] = $time_func($file_path);
    }
    // 逆序,最新的文件在前面
    arsort($files);
    $files = array_keys($files);
    return $files ? $files : false;
}
