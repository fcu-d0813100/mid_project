<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$nation = $_POST["nation"];
$gender = $_POST["gender"];
$years = $_POST["years"];
$email = $_POST["email"];

$sql = "UPDATE teachers SET name='$name',nation='$nation', gender='$gender',years='$years',email='$email'
WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // $last_id = $conn->insert_id;
    // echo "新資料輸入成功, id 為 $last_id";

    // 插入圖片
    if ($_FILES["pic"]["error"] == 0) {
        $filename = $_FILES["pic"]["name"];
        $fileInfo = pathinfo($filename);
        $extension = $fileInfo["extension"];
        $newFilename = time() . ".$extension";

        if (move_uploaded_file($_FILES["pic"]["tmp_name"], "./upload/" . $newFilename)) {
            $sql = "UPDATE teachers SET main_picture = '$newFilename' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                header("location:teacher.php?id={$id}"); // 跳轉到上傳成功頁面
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            echo "圖片上傳成功";
        } else {
            echo "圖片上傳失敗";
        }
    }

    header("location:teacher.php?id={$id}");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();

// if ($conn->query($sql) === TRUE) {
//     echo "更新成功";
// } else {
//     echo "更新資料錯誤： " . $conn->error;
// }

// header("location:teacher.php?id={$id}");

// $conn->close();
