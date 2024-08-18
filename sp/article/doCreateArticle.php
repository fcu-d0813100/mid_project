<?php
require("/xampp/htdocs/mid_project/db_connect.php");

if(!isset($_POST["brand"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$brand = $_POST["brand"];
$type = $_POST["type"];
$title = $_POST["title"];

$content =$_POST["content"];
// $pic = $_FILES["pic"];
$date = $_POST["date"];

$sql = "INSERT INTO article (brand_id, type_id, title, content, launched_date)
        VALUES ('$brand','$type','$title', '$content', '$date')";
// $sql = "INSERT INTO article_images (article_id, name1)
//     VALUES ('')";


var_dump($sql);

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";


    // 跳轉到文章列表頁面
    header("Location: article-list.php");
    exit;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
