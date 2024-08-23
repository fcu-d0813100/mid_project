<?php
require_once("../../db_connect.php");


// 確保傳遞的ID有效
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    die("無效ID");
}


$delete_sql = "DELETE FROM sub_category WHERE id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: category.php");
    exit();
} else {
    die("刪除失敗: " . $conn->error);
}

$stmt->close();
$conn->close();
