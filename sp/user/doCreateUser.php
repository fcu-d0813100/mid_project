<?php
require_once("../../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 檢查其他表單數據
    if (!isset($_POST["name"]) || !isset($_FILES["meupload"])) {
        echo "請循正常管道進入此頁";
        $conn->close();
        exit;
    }

    $account = $_POST["account"];
    if (empty($account)) {
        echo "帳號不能為空";
        $conn->close();
        exit;
    }

    // 檢查帳號是否已存在
    $sqlCheck = "SELECT * FROM users WHERE account = '$account'";
    $result = $conn->query($sqlCheck);
    if ($result === FALSE) {
        echo "查詢帳號時發生錯誤: " . $conn->error;
        $conn->close();
        exit;
    }
    $userCount = $result->num_rows;

    if ($userCount > 0) {
        echo "該帳號已存在";
        $conn->close();
        exit;
    }

    $password = $_POST["password"];
    if (empty($password)) {
        echo "密碼不能為空";
        $conn->close();
        exit;
    }
    $repassword = $_POST["repassword"];
    if ($password != $repassword) {
        echo "密碼輸入不一致";
        $conn->close();
        exit;
    }
}

$password = md5($password);
$name = $_POST["name"];
$gender = $_POST["gender"];
$phone = $_POST["phone"];
$birthday = $_POST["birthday"];
$email = $_POST["email"];
$address = $_POST["city"] . $_POST["streetAddress"];
$level_id = $_POST["level_id"];

$now = date('Y-m-d H:i:s');

// 插入新記錄到資料庫
$sql = "INSERT INTO users (account, password, name, gender, phone, birthday, email, address, created_at, level_id, valid)
            VALUES ('$account', '$password', '$name', '$gender', '$phone', '$birthday', '$email', '$address', '$now', '$level_id', 1)";


if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";
    // 插入圖片
    if ($_FILES["meupload"]["error"] == 0) {
        $filename = $_FILES["meupload"]["name"];
        $fileInfo = pathinfo($filename);
        $extension = $fileInfo["extension"];
        $newFilename = time() . ".$extension";

        if (move_uploaded_file($_FILES["meupload"]["tmp_name"], "./upload/" . $newFilename)) {
            $sql = "UPDATE users SET member_img = '$newFilename' WHERE id = $last_id";
            if ($conn->query($sql) === TRUE) {
                header("Location: users.php"); // 跳轉到上傳成功頁面
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            echo "圖片上傳成功";
        } else {
            echo "圖片上傳失敗";
        }
    }

    header("Location: users.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
