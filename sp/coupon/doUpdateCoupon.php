<?php

require_once("../db_connect.php");

if(!isset($_POST["name"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$name=$_POST["name"];
$email=$_POST["email"];
$phone=$_POST["phone"];


$sql="UPDATE users SET name='$name',phone='$phone',email='$email' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: user-edit.php?id=$id");

$conn->close();
