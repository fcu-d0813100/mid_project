<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}
$id = $_POST["id"];
$name = $_POST["name"];
$brand = $_POST["brand"];
$image = $_POST["image"];
$start_at = $_POST["start_at"];
$end_at = $_POST["end_at"];
$address = $_POST["address"];

$maxAPP = $_POST["maxAPP"];
$description = $_POST["description"];


$sql = "UPDATE active SET brand = '$brand', name = '$name', image = '$image', start_at = '$start_at', end_at = '$end_at', address = '$address', maxAPP = '$maxAPP', description = '$description' WHERE id = '$id'";
$result = $conn->query($sql);




if ($result === TRUE) {
    echo "修乾成功";



    // 跳轉到文章列表頁面
    header("Location: active.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("location: active.php");
$conn->close();
