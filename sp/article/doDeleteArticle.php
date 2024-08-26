<?php
if (!isset($_GET["id"])) {
    echo "請循正常管道進入";
    exit;
}
require_once("../../db_connect.php");


$id = $_GET["id"];
$sql="UPDATE article SET valid=0 WHERE id=$id";  //軟刪除


if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}


$conn->close();


header("location:article-list.php"); //刪完之後回到哪邊