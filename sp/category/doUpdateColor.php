<?php
require_once("./productdb_connect.php");

if (!isset($_GET["id"]) || !isset($_GET["stock"]) || !isset($_GET["color"])) {
    echo "請正確帶入所有必要的變數";
    exit;
}

$id = $_GET["id"];
$stock = $conn->real_escape_string($_GET["stock"]);
$color = $conn->real_escape_string($_GET["color"]);


$sql = "SELECT product_id FROM color WHERE id=$id";
$result = $conn->query($sql);


if ($result->num_rows === 0) {
    die("找不到商品");
}

$product = $result->fetch_assoc();
$product_id = $product['product_id'];

$checkSql = "SELECT id FROM color WHERE product_id=$product_id AND color='$color' AND id != $id";
$checkResult = $conn->query($checkSql);


if ($checkResult->num_rows > 0) {
    echo "<script>alert('該商品已經存在相同色號 !'); window.history.back();</script>";
    exit();
}

// 更新資料
$sql = "UPDATE color SET color='$color', stock='$stock' WHERE id=$id";


if ($conn->query($sql) === TRUE) {
    header("Location: color.php");
    exit();
} else {
    die("更新資料錯誤: " . $conn->error);
}

$conn->close();
