<?php
require_once("./productdb_connect.php");



if (!isset($_GET["id"]) || !isset($_GET["sub_name"]) || !isset($_GET["main_category_id"])) {
    echo "請正確帶入所有必要的變數";
    exit;
}

$id = $_GET['id'];
$sub_name = $_GET["sub_name"];
$main_category_id = $_GET["main_category_id"];

$check = "SELECT COUNT(*) as count 
FROM sub_category
WHERE name='$sub_name' 
AND id !=$id";

$check_result = $conn->query($check);
$check_row = $check_result->fetch_assoc();

if ($check_row['count'] > 0) {
    echo "<script>alert('該品項已經存在 !'); window.history.back();</script>";
    exit();
}

$sql = "UPDATE sub_category 
SET name = '$sub_name', main_category_id =$main_category_id
WHERE id = $id";
$result = $conn->query($sql);

if ($result) {
    header("Location: category.php");
    exit();
} else {
    die("更新失敗: " . $conn->error);
}

$conn->close();
