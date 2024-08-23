<?php
include('../../db_pdo.php');

// 開啟錯誤報告
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = ['success' => false, 'error' => ''];

// 確認請求是否有效
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = (int)$_POST['id'];

    try {
        // 開始刪除操作

        $pdo->beginTransaction();

        // 刪除 color 表格中與該產品相關的記錄
        $deleteColorSql = "DELETE FROM color WHERE product_id = :product_id";
        $stmtDeleteColor = $pdo->prepare($deleteColorSql);
        $stmtDeleteColor->execute(['product_id' => $productId]);

        // 刪除 product_list 表格中的記錄
        $deleteProductSql = "DELETE FROM product_list WHERE id = :id";
        $stmtDeleteProduct = $pdo->prepare($deleteProductSql);
        $stmtDeleteProduct->execute(['id' => $productId]);

        // 提交刪除操作
        $pdo->commit();

        $response['success'] = true;
    } catch (Exception $e) {
        // 回滾事務
        $pdo->rollBack();
        $response['error'] = $e->getMessage();
    }
} else {
    $response['error'] = '無效的請求';
}

// 返回 JSON 格式的響應
header('Content-Type: application/json');
echo json_encode($response);
