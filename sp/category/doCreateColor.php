<?php

require_once("../../db_connect.php");



if (isset($_GET['color']) && isset($_GET['stock']) && isset($_GET['product_id'])) {
    $color = $_GET['color'];
    $stock = $_GET['stock'];
    $product_id = $_GET['product_id'];

    if ($color && $stock >= 0 && $product_id > 0) {
        // 檢查顏色
        $check_sql = "SELECT COUNT(*) as count FROM color WHERE color= '$color' AND product_id = $product_id";
        $check_result = $conn->query($check_sql);

        if ($check_result) {
            $check_row = $check_result->fetch_assoc();

            if ($check_row['count'] > 0) {
                echo "<script>alert('已有此色號 !'); window.location.href='create-color.php';</script>";
                exit();
            } else {
                // 插入
                $insert_sql = "INSERT INTO color (color, stock, product_id) VALUES ('$color', $stock, $product_id)";
                if ($conn->query($insert_sql)) {
                    header("Location: color.php");
                    exit();
                } else {
                    die("Error: " . $conn->error . "<br>SQL: " . $insert_sql);
                }
            }
        } else {
            die("Error: " . $conn->error);
        }
    } else {
        echo "<script>alert('請填齊資料 !'); window.location.href='create-color.php';</script>";
    }
}
