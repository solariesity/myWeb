<?php
header("Content-Type:application/json");

$result = file_get_contents(":/input");

$data = json_decode($result);

echo json_encode($data);
