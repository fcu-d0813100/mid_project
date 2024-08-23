<?php
include('../../db_pdo.php');

if (isset($_POST['main_category_id'])) {
    $mainCategoryId = $_POST['main_category_id'];
    $stmt = $pdo->prepare("SELECT id, name FROM sub_category WHERE main_category_id = ?");
    $stmt->execute([$mainCategoryId]);
    $subCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subCategories as $subCategory) {
        echo "<option value='{$subCategory['id']}'>{$subCategory['name']}</option>";
    }
}
