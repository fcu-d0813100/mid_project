<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

// $account=$_POST["account"];
// if(empty($account)){
//     echo "帳號不能為空";
//     exit;
// }
// $password=$_POST["password"];
// if(empty($password)){
//     echo "密碼不能為空";
//     exit;
// }

// $sqlCheck="SELECT *FROM coupon_list WHERE code ='$code'";
// $result=$conn->query($sqlCheck);
// $couponCount=$result->num_rows;
// if($couponCount>0){
//     echo "優惠券已存在";
//     exit;
// }

// echo $userCount;
// exit;

// $repassword=$_POST["repassword"];
// if($password!=$repassword){
//     echo "密碼輸入不一致";
//     exit;
// }

$id=$_POST["id"];
$name=$_POST["name"];
$minimum_amount=$_POST["minimum_amount"];
$discount_value=$_POST["discount_value"];
$code=$_POST["code"];
$maximum=$_POST["maximum"];
$start_date=$_POST["start_date"];
$end_date=$_POST["end_date"];

$sql = "INSERT INTO coupon_list (name,minimum_amount,maximum, start_date, end_date,discount_value,code,valid)
	VALUES ('$name','$minimum_amount','$maximum', '$start_date', '$end_date','$discount_value','$code',1)";

// echo $sql;
// exit;

if ($conn->query($sql) === TRUE) {
    $last_id=$conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("location: coupon-list.php?id=$id");

$conn->close();
