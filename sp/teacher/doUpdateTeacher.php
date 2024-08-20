<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$nation = $_POST["nation"];
$gender = $_POST["gender"];
$years = $_POST["years"];
$email = $_POST["email"];

$sql = "UPDATE teachers SET name='$name',nation='$nation', gender='$gender',years='$years',email='$email'
WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤： " . $conn->error;
}

header("location:teacher.php?id={$id}");

$conn->close();
