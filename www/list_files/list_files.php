<?php
header("Content-Type:application/json");

function getRelativePath($from, $to) {
    $from = str_replace('\\', '/', $from);
    $to = str_replace('\\', '/', $to);
    $fromParts = explode('/', trim($from, '/'));
    $toParts = explode('/', trim($to, '/'));

    $i = 0;
    while (isset($fromParts[$i], $toParts[$i]) && $fromParts[$i] === $toParts[$i]) {
        $i++;
    }

    $backLevels = count($fromParts) - $i;
    $relativePath = str_repeat('../', $backLevels) . implode('/', array_slice($toParts, $i));
    return $relativePath ?: './';
}

$json = file_get_contents("php://input");

$path_json = json_decode($json, true);

$path = $path_json["path"];

$document_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . "document" . DIRECTORY_SEPARATOR . $path;

$items = scandir($document_path);

$files = [];

foreach($items as $item){
    if ($item == "." || $item == ".."){
        continue;
    }

    $file = [];
    $real_path = realpath($document_path . DIRECTORY_SEPARATOR . $item);

    $file["name"] = $item;
    $file["is_dir"] = is_dir($real_path);
    $file["real_path"] = getRelativePath(dirname(__DIR__) . DIRECTORY_SEPARATOR . "document", $real_path);
    $files[] = $file;
}
echo json_encode($files);