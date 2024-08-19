<?php
require("/xampp/htdocs/mid_project/db_connect.php");

if(!isset($_POST["brand"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$brand = $_POST["brand"];
$type = $_POST["type"];
$title = $_POST["title"];
$content = $_POST["content"];
$date = $_POST["date"];

// 插入文章，先不插入圖片
$sql = "INSERT INTO article (brand_id, type_id, title, content, launched_date)
        VALUES ('$brand', '$type', '$title', '$content', '$date')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id; // 獲取剛剛插入的文章的 ID
    echo "新資料輸入成功, id 為 $last_id";

    // 處理圖片上傳
    if($_FILES["main_pic"]["error"] == 0){
        $fileName = $_FILES["main_pic"]["name"];
        $fileinfo = pathinfo($fileName);
        $extension = $fileinfo["extension"];
        $newFilename = time().".$extension"; // 重新命名圖片檔名

        if(move_uploaded_file($_FILES["main_pic"]["tmp_name"], "./pic/".$newFilename)){
            // 更新剛剛插入的文章的 main_pic 欄位
            $sql = "UPDATE article SET main_pic = '$newFilename' WHERE id = '$last_id'";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: article-list.php"); // 跳轉到上傳成功頁面
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
    header("Location: article-list.php");
    exit;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
