<?php

require_once("../../db_connect.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入此頁";
    exit;
}
$name = $_POST["name"];
$brand = $_POST["brand"];
$image = $_POST["image"];
$start_at = $_POST["start_at"];
$end_at = $_POST["end_at"];
$address = $_POST["address"];

$maxAPP = $_POST["maxAPP"];
$description = $_POST["description"];


$sql  = "INSERT INTO active (brand,name,image,start_at,end_at,address,maxAPP,description)
         VALUES ('$brand','$name','$image','$start_at','$end_at','$address','$maxAPP','$description')";



if ($conn->query($sql) === TRUE) {
    echo "新資料輸入成功";
    $last_id = $conn->insert_id;
    echo "新增資料成功， id 為$last_id";
    if ($_FILES["image"]["error"] == 0) {
        $fileName = $_FILES["image"]["name"];
        $fileinfo = pathinfo($fileName);
        $extension = $fileinfo["extension"];
        $newFilename = time() . ".$extension"; // //這裡用time方法是為了避免出現同個檔名 重新命名圖片檔名

        if (move_uploaded_file($_FILES["image"]["tmp_name"], "./images/" . $newFilename)) {
            // 更新剛剛插入的文章的 main_pic 欄位
            $sql = "UPDATE active SET image = '$newFilename' WHERE id = '$last_id'";

            if ($conn->query($sql) === TRUE) {
                header("Location: active.php"); // 跳轉到上傳成功頁面
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            echo "圖片上傳成功";
        } else {
            echo "圖片上傳失敗";
        }
    }

    // 跳轉到文章列表頁面
    header("Location: active.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("location: active.php");
$conn->close();
