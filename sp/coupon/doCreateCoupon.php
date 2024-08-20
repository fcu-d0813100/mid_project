<?php

require_once("../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$account=$_POST["account"];
if(empty($account)){
    echo "帳號不能為空";
    exit;
}
$password=$_POST["password"];
if(empty($password)){
    echo "密碼不能為空";
    exit;
}

$sqlCheck="SELECT *FROM users WHERE account ='$account'";
$result=$conn->query($sqlCheck);
$userCount=$result->num_rows;
if($userCount>0){
    echo "帳號已存在";
    exit;
}
// echo $userCount;
// exit;

$repassword=$_POST["repassword"];
if($password!=$repassword){
    echo "密碼輸入不一致";
    exit;
}
$password=md5($password);
$name = $_POST["name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$now = date('Y-m-d H:i:s');

$sql = "INSERT INTO users (account,password,name, phone, email, created_at,valid)
	VALUES ('$account','$password','$name', '$phone', '$email', '$now',1)";

// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    $last_id=$conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("location: users.php?id=$id");

$conn->close();
