<?php
include('../../db_pdo.php');

// 獲取傳入的主分類 ID
$mainCategoryId = isset($_POST['main_category_id']) ? (int)$_POST['main_category_id'] : 0;

// 初始化回應數據
$response = array('sub_categories' => array());

try {
    // SQL 查詢，根據主分類 ID 獲取對應的子分類
    $sql = "SELECT id, name FROM sub_category WHERE main_category_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$mainCategoryId]);

    // 獲取結果集
    $sub_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 將子分類加入回應數據
    $response['sub_categories'] = $sub_categories;
} catch (Exception $e) {
    // 如果發生錯誤，將錯誤信息加入回應數據
    $response['error'] = '無法獲取子分類: ' . $e->getMessage();
}
// 返回 JSON 格式的回應數據
echo json_encode($response);
