<?php
require_once("./productdb_connect.php");

if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    exit;
}
$id = $_GET["id"];
$current_time = date('Y-m-d H:i:s');

$sql = "UPDATE color SET valid=0 WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

$conn->close();

header("Location: color.php");
