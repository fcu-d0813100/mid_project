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

// var_dump($_FILES["pic"]);
// exit;

$password = md5($password);

$name = $_POST["name"];
$nation = $_POST["nation"];
$gender = $_POST["gender"];
$years = $_POST["years"];
$email = $_POST["email"];
$now = date('Y-m-d H:i:s');

// $pic = $_FILES["pic"];

$sql = "INSERT INTO teachers (account,password, name, email , gender,years, nation,slogan,about,experience, created_at,valid )
	VALUES ('$account','$password','$name','$email','$gender', '$years','$nation','' ,'','','$now',1)";


if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";

    // 插入圖片
    if ($_FILES["pic"]["error"] == 0) {
        $filename = $_FILES["pic"]["name"];
        $fileInfo = pathinfo($filename);
        $extension = $fileInfo["extension"];
        $newFilename = time() . ".$extension";

        if (move_uploaded_file($_FILES["pic"]["tmp_name"], "./upload/" . $newFilename)) {
            $sql = "UPDATE teachers SET main_picture = '$newFilename' WHERE id = $last_id";
            if ($conn->query($sql) === TRUE) {
                header("Location: teachers.php"); // 跳轉到上傳成功頁面
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            echo "圖片上傳成功";
        } else {
            echo "圖片上傳失敗";
        }
    }

    header("Location:teachers.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();
