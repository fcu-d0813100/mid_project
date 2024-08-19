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

// 目前頁面有問題


// $sql = "UPDATE users SET level_id = '".$_POST['level_id']."' WHERE user_id = '".$_POST['user_id']."'";

// $sql = "UPDATE users SET gender = '$gender' WHERE user_id = '".$_POST['user_id']."'";

// $sql = "UPDATE users SET name='$name',gender='$gender' ,phone='$phone',  birthday='$birthday', email='$email' , address='$address', level_id = '" . $_POST['level_id'] . "' WHERE id=$id";

$sql = "UPDATE users SET name = '$name', gender = '$gender', level_id = '$level_id', phone = '$phone', birthday = '$birthday', email = '$email', address = '$address' WHERE id = '$id'";

// $sql = "UPDATE users SET  name='$name',gender='$gender' ,phone='$phone',  birthday='$birthday', email='$email' , address='$address', level_id = '" . $_POST['level_id'] . "' WHERE id=$id";

// (account, password, name ,gender, phone,birthday, email,address,created_at,level_id, valid)
// VALUES ('$account', '$password', '$name','$gender' ,'$phone','$birthday', '$email','$address','$level_id',1)";


if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: user-edit.php?id=$id");

$conn->close();
