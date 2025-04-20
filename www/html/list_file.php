<?php
header("Content-Type:application/json");

$path = __DIR__;

if (isset($_GET["path"])){
    $path = dirname(__DIR__) . "\document\\" . $_GET["path"];
}
else{
    $path = dirname(__DIR__) . "\document";
}

//echo $path;

$files = scandir($path);

$results = array();

foreach ($files as $file){
    if ($file == '.' || $file == '..') continue;

    $full_file = $path . '\\' . $file;
    $file_info = [
        "file_name" => $file,
        "is_dir" => is_dir($full_file),
        "time" => filemtime($full_file)
    ];
    $results[] = $file_info;
}



echo json_encode($results);

?>