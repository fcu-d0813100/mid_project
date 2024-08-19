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
$content =$_POST["content"];
// $pic = $_FILES["pic"];
$date = $_POST["date"];

// 撈取 brand 資料
$sqlBrands = "SELECT id, name FROM brand";
$resultBrands = $conn->query($sqlBrands);
$brands = $resultBrands->fetch_all(MYSQLI_ASSOC);

// 撈取 type 資料
$sqlTypes = "SELECT id, name FROM article_type";
$resultTypes = $conn->query($sqlTypes);
$types = $resultTypes->fetch_all(MYSQLI_ASSOC);


$sql = "UPDATE article SET brand_id='$brand', type_id='$type', title='$title', content='$content', launched_date='$date'
WHERE id=$id;
";


if ($conn->query($sql) === TRUE) {
    // $last_id = $conn->insert_id;
    echo "修改成功";


    // 跳轉到文章列表頁面
    header("Location: article-list.php");
    exit;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>