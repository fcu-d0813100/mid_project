<?php

require_once("../../db_connect.php");

if(!isset($_POST["id"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$pay_id=$_POST["pay_id"];
$status_id=$_POST["status_id"];


$sql="UPDATE user_order SET pay_id='$pay_id',status_id='$status_id'
WHERE id='$id' " ;

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else { 
    echo "更新資料錯誤: " . $conn->error;
}

header("location: order.php?id=$id");

$conn->close();
