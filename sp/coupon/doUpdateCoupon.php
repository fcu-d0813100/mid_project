<?php

require_once("../../db_connect.php");

if(!isset($_POST["id"])) {
    echo "請循正常管道進入此頁";
    exit;
}
$id = $_POST["id"];
$name = $_POST["name"];
$minimum_amount = $_POST["minimum_amount"];
$type_id = $_POST["type_id"];
$discount_value = $_POST["discount_value"];
$maximum = $_POST["maximum"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];



$sql = "UPDATE coupon_list SET name='$name', minimum_amount='$minimum_amount', type_id='$type_id', discount_value='$discount_value',start_date='$start_date', maximum='$maximum', end_date='$end_date' WHERE id='$id'";

$result = $conn->query($sql);

if ($result === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location:coupon.php?id=$id");

$conn->close();
