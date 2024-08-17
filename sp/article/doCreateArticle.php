<?php
require("./db_connect.php");

if(!isset($_POST["title"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$title = $conn->real_escape_string($_POST["title"]);
$content = $conn->real_escape_string($_POST["content"]);
$date = $conn->real_escape_string($_POST["date"]);

$sql = "INSERT INTO article_list (title, content, launched_date)
        VALUES ('$title', '$content', '$date')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, id 為 $last_id";


$sql_tag = "INSERT INTO article_tag_relation (article_id, tag_id)
            VALUES ('$last_id', '$tag_id')";
$conn->query($sql_tag);

    // 跳轉到文章列表頁面
    header("Location: article-list.php");
    exit;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
