<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$account = $_POST["account"];
if (empty($account)) {
    echo "帳號不能為空";
    exit;
}

$sqlCheck = "SELECT * FROM teachers WHERE account = '$account' ";
$result = $conn->query($sqlCheck);
$userCount = $result->num_rows;
if ($userCount > 0) {
    echo "該帳號已存在";
    exit;
}

$password = $_POST["password"];
if (empty($password)) {
    echo "密碼不能為空";
    exit;
}

$repassword = $_POST["repassword"];
if ($password != $repassword) {
    echo "密碼輸入不一致";
    exit;
}

$password = md5($password);

$name = $_POST["name"];
$nation = $_POST["nation"];
$gender = $_POST["gender"];
$years = $_POST["years"];
$email = $_POST["email"];
$now = date('Y-m-d H:i:s');

$sql = "INSERT INTO teachers (account,password, name, email , gender,years, nation,slogan,about,experience , created_at,valid )
	VALUES ('$account','$password','$name','$email','$gender', '$years','$nation','' ,'','' ,'$now',1)";

// echo $sql;

if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("location:teachers.php");

$conn->close();
