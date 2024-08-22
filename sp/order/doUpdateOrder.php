<?php

require_once("../../db_connect.php");

if(!isset($_POST["id"])){
    echo "請循正常管道進入此頁";
    exit;
}

$id=$_POST["id"];
$pay=$_POST["pay"];
$status=$_POST["status"];


$sql="UPDATE user_order SET pay_id='$pay',status_id='$status'
WHERE id='$id' AND user_order.valid=1" ;

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else { 
    echo "更新資料錯誤: " . $conn->error;
}

header("location: order-edit.php?id=$id");

$conn->close();
