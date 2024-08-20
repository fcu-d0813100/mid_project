<?php
include('../config/database.php');

// 初始化變數
$productId = 1; // 假設我們更新id為1的商品
$description = "";
$imageName = "";

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 更新描述
    if (!empty($_POST['description'])) {
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
        $updateDescriptionSql = "UPDATE product_list SET description = :description WHERE id = :id";
        $stmt = $pdo->prepare($updateDescriptionSql);
        $stmt->execute(['description' => $description, 'id' => $productId]);
    }

    // 更新圖片
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;

        // 上傳圖片並更新資料庫
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $updateImageSql = "UPDATE product_images SET mainimage = :mainimage WHERE id = :id";
            $stmt = $pdo->prepare($updateImageSql);
            $stmt->execute(['mainimage' => $imageName, 'id' => $productId]);
        } else {
            echo "圖片上傳失敗。";
        }
    }
}

// 獲取當前商品資料
$productSql = "SELECT pi.mainimage, pl.description 
               FROM product_images pi 
               JOIN product_list pl ON pi.images_id = pl.id 
               WHERE pi.images_id = :id";
$stmt = $pdo->prepare($productSql);
$stmt->execute(['id' => $productId]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $imageName = $row['mainimage'];
    $description = $row['description'];
} else {
    echo "找不到商品資料。";
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品頁</title>
</head>
<body>
<h2>商品頁</h2>

<!-- 顯示圖片 -->
<?php if ($imageName): ?>
    <img src="../uploads/<?php echo htmlspecialchars($imageName, ENT_QUOTES, 'UTF-8'); ?>" alt="商品圖片" style="max-width: 200px;">
<?php else: ?>
    <p>無圖片</p>
<?php endif; ?>

<!-- 顯示描述 -->
<p>描述: <?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></p>

<!-- 更新表單 -->
<form action="" method="post" enctype="multipart/form-data">
    <label for="image">更新圖片:</label>
    <input type="file" name="image" id="image"><br><br>

    <label for="description">更新描述:</label><br>
    <textarea name="description" id="description" rows="4" cols="50"><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></textarea><br><br>

    <input type="submit" value="更新">
</form>

</body>
</html>
