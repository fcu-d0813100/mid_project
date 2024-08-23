<?php
if (!isset($_POST["title"])) {
    echo "請循正常管道進入此頁";
    exit;
}
require_once("/xampp/htdocs/mid_project/db_connect.php");

$id = $_POST["id"];
$brand = $_POST["brand"];
$type = $_POST["type"];
$title = $_POST["title"];
$content = $_POST["content"];
$pic = $_FILES["pic"];
$date = $_POST["date"];

// 撈取 brand 資料
$sqlBrands = "SELECT id, name FROM brand";
$resultBrands = $conn->query($sqlBrands);
$brands = $resultBrands->fetch_all(MYSQLI_ASSOC);

// 撈取 type 資料
$sqlTypes = "SELECT id, name FROM article_type";
$resultTypes = $conn->query($sqlTypes);
$types = $resultTypes->fetch_all(MYSQLI_ASSOC);

// 更新文章資料
$sql = "UPDATE article SET brand_id='$brand', type_id='$type', title='$title', content='$content', launched_date='$date' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "修改成功";

    // 處理圖片上傳
    if ($_FILES["main_pic"]["error"] == 0) {
        $fileName = $_FILES["main_pic"]["name"];
        $fileinfo = pathinfo($fileName);
        $extension = $fileinfo["extension"];
        $newFilename = time() . ".$extension"; // 重新命名圖片檔名

        if (move_uploaded_file($_FILES["main_pic"]["tmp_name"], "./pic/" . $newFilename)) {
            // 更新剛剛更新的文章的 main_pic 欄位
            $sql = "UPDATE article SET main_pic = '$newFilename' WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {
                header("Location: article-list.php"); // 跳轉到更新成功頁面
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
