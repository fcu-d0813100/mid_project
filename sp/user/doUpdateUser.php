<!-- doUpdateUser -->
<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$gender_map = array(
    '男' => 1,
    '女' => 2
);

$level_id_map = array(
    '一般會員' => 1,
    'VIP' => 2,
    '管理員' => 3
);


$id = $_POST["id"];
$name = $_POST["name"];
$gender = $_POST["gender"];
$phone = $_POST["phone"];
$birthday = $_POST["birthday"];
$email = $_POST["email"];
$address = $_POST["city"] . $_POST["streetAddress"];
$level_id = $_POST["level_id"];


// $id = $_POST["id"];
// $name = $_POST["name"];
// $gender = $_POST["gender"];
// $phone = $_POST["phone"];
// $level_id = $_POST['level_id'];
// // $sql = "UPDATE users SET level_id = '" . $_POST['level_id'] . "' WHERE user_id = '" . $_POST['user_id'] . "'";
// $birthday = $_POST["birthday"];
// $email = $_POST["email"];
// $address = $_POST["address"];

// $sql = "UPDATE users SET level_id = '".$_POST['level_id']."' WHERE user_id = '".$_POST['user_id']."'";

// $sql = "UPDATE users SET gender = '$gender' WHERE user_id = '".$_POST['user_id']."'";

$sql = "INSERT INTO users (account, password, name ,gender, phone,birthday, email,address,created_at,level_id, valid)
	VALUES ('$account', '$password', '$name','$gender' ,'$phone','$birthday', '$email','$address','$level_id',1)";


// $sql = "UPDATE users SET  name='$name',gender='$gender' ,phone='$phone',  birthday='$birthday', email='$email' , address='$address', level_id = '" . $_POST['level_id'] . "' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: user-edit.php?id=$id");

$conn->close();
