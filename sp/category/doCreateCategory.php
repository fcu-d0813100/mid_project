<?php

require_once("./productdb_connect.php");

if (!isset($_GET["category"]) || !isset($_GET["main_category_id"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$category = $_GET["category"];
if (empty($category)) {
    echo "品項不能為空";
    exit;
}

$sqlCheck = "SELECT * FROM sub_category WHERE name = '$category'";
$result = $conn->query($sqlCheck);
$categoryCount = $result->num_rows;

if ($categoryCount > 0) {
    echo "<script>alert('該品項已存在'); window.location.href='create-category.php';</script>";
    exit;
}

$main_category_id = $_GET["main_category_id"];

$sql = "INSERT INTO sub_category (name, main_category_id) VALUES ('$category', '$main_category_id')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新資料輸入成功, 品項id 為 $last_id";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("Location: category.php"); // 确保这个重定向地址正确
$conn->close();
