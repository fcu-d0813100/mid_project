<?php

require_once("../../db_connect.php");

if (!isset($_GET["id"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_GET["id"];

$sql = "UPDATE teachers SET valid= 0
WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤： " . $conn->error;
}

header("location:teachers.php");

$conn->close();
