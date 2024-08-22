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
// $member_img = $_POST["member_img"];


$sql = "UPDATE users SET name = '$name', gender = '$gender', level_id = '$level_id', phone = '$phone', birthday = '$birthday', email = '$email', address = '$address' WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    // $last_id = $conn->insert_id;
    // echo "新資料輸入成功, id 為 $last_id";
    // 插入圖片
    if ($_FILES["meupload"]["error"] == 0) {
        $filename = $_FILES["meupload"]["name"];
        $fileInfo = pathinfo($filename);
        $extension = $fileInfo["extension"];
        $newFilename = time() . ".$extension";

        if (move_uploaded_file($_FILES["meupload"]["tmp_name"], "./upload/" . $newFilename)) {
            $sql = "UPDATE users SET member_img = '$newFilename' WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                header("Location: user.php?id=$id"); // 跳轉到上傳成功頁面
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            echo "圖片上傳成功";
        } else {
            echo "圖片上傳失敗";
        }
    }

    header("Location: user.php?id=$id");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



// if ($conn->query($sql) === TRUE) {
//     echo "更新成功";
// } else {
//     echo "更新資料錯誤: " . $conn->error;
// }

header("location: user.php?id=$id");

$conn->close();
