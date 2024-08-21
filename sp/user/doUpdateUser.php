<!-- doUpdateUser -->
<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$gender = $_POST["gender"];
$level_id = $_POST["level_id"];
$phone = $_POST["phone"];
$birthday = $_POST["birthday"];
$email = $_POST["email"];
$address = $_POST["address"];
$member_img = $_POST["member_img"];


$sql = "UPDATE users SET name = '$name', gender = '$gender', level_id = '$level_id', phone = '$phone', birthday = '$birthday', email = '$email', address = '$address', member_img = '$member_img' WHERE id = '$id'";


if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: user.php?id=$id");

$conn->close();
