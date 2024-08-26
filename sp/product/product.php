<?php
include('../../db_pdo.php');

// 獲取動態 productId 和 colorId
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$colorId = isset($_GET['color_id']) ? (int)$_GET['color_id'] : 1;

$productName = "";
$brandName = "";
$mainCategoryName = "";
$subCategoryName = "";
$colorName = "";
$price = 0.0;
$imageName = "";
$description = "";
$stock = 0; // 初始化庫存變量

// 獲取當前商品數據
$productSql = "SELECT pl.product_name, b.name AS brand_name, mc.name AS main_category_name, 
                      sc.name AS sub_category_name, c.id AS color_id, c.color AS color_name, pl.price, 
                      c.mainimage, pl.description, c.stock
               FROM product_list pl
               JOIN brand b ON pl.brand_id = b.id
               JOIN main_category mc ON pl.main_category_id = mc.id
               JOIN sub_category sc ON pl.sub_category_id = sc.id
               JOIN color c ON pl.id = c.product_id
               WHERE pl.id = :product_id AND c.id = :color_id";
$stmt = $pdo->prepare($productSql);
$stmt->execute(['product_id' => $productId, 'color_id' => $colorId]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $productName = $row['product_name'];
    $brandName = $row['brand_name'];
    $mainCategoryName = $row['main_category_name'];
    $subCategoryName = $row['sub_category_name'];
    $colorName = $row['color_name'];
    $price = $row['price'];
    $imageName = $row['mainimage'];
    $description = $row['description'];
    $stock = $row['stock']; // 獲取庫存數據
} else {
    echo "找不到商品資料。";
    echo "<br>product_id: $productId";
    echo "<br>color_id: $colorId";
    exit();
}

// 更新資料庫中的數據
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 檢查是否有更新圖片的請求
    if (!empty($_FILES['product_image']['name'])) {
        $targetDir = "uploads/";
        $imageFileType = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $imageName = uniqid() . '.' . $imageFileType;
        $targetFilePath = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFilePath)) {
            // 只更新 color 表格的圖片字段
            $updateImageSql = "UPDATE color SET mainimage = :image_name WHERE id = :color_id AND product_id = :product_id";
            $stmtUpdateImage = $pdo->prepare($updateImageSql);
            $stmtUpdateImage->execute([
                'image_name' => $imageName,
                'color_id' => $colorId,
                'product_id' => $productId
            ]);
        } else {
            echo "圖片上傳失敗。";
            exit();
        }
    }

    // 檢查是否有更新其他內容的請求
    if (isset($_POST['product_name']) || isset($_POST['color_name']) || isset($_POST['price']) || isset($_POST['description']) || isset($_POST['stock'])) {
        $updatedProductName = trim($_POST['product_name']);
        $updatedColorName = trim($_POST['color_name']);
        $updatedPrice = (float)str_replace("元", "", trim($_POST['price']));
        $updatedDescription = trim($_POST['description']);
        $updatedStock = (int)trim($_POST['stock']);

        // 更新 product_list 表格
        $updateProductSql = "UPDATE product_list 
                             SET product_name = :product_name, price = :price, description = :description 
                             WHERE id = :product_id";
        $stmtUpdateProduct = $pdo->prepare($updateProductSql);
        $stmtUpdateProduct->execute([
            'product_name' => $updatedProductName,
            'price' => $updatedPrice,
            'description' => $updatedDescription,
            'product_id' => $productId
        ]);

        // 更新 color 表格
        $updateColorSql = "UPDATE color 
                           SET color = :color_name, stock = :stock 
                           WHERE id = :color_id AND product_id = :product_id";
        $stmtUpdateColor = $pdo->prepare($updateColorSql);
        $stmtUpdateColor->execute([
            'color_name' => $updatedColorName,
            'stock' => $updatedStock,
            'color_id' => $colorId,
            'product_id' => $productId
        ]);
    }

    // 重新加載頁面以顯示最新的數據，包括新圖片
    header("Location: product.php?id=$productId&color_id=$colorId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品頁</title>
    <?php include("css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content">
        <div class="container">
            <div class="d-flex justify-content-between my-2 pt-5 mt-5">
                <div>
                    <a href="product_list.php" class="btn btn-dark reverse py-2"><i class="fa-solid fa-chevron-left fa-fw"></i></a>
                </div>
                <div d-flex>
                    <button type="button" class="btn btn-dark py-2 me-2 edit-button"><i class="fa-solid fa-pen fa-fw"></i></button> <!-- 編輯按鈕 -->
                    <button type="submit" form="productForm" class="btn btn-dark py-2 save-button"><i class="fa-solid fa-cloud-arrow-down fa-fw"></i></button>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <?php if ($imageName): ?>
                    <div class="product-image col-5">
                        <div class="ratio ratio-1x1">
                            <img src="./uploads/<?php echo htmlspecialchars($imageName, ENT_QUOTES, 'UTF-8'); ?>" alt="商品圖片" style="width: 100%;">
                        </div>
                    </div>
                <?php else: ?>
                    <p>無圖片</p>
                <?php endif; ?>
                <div class="product-details col-6">

                    <form id="productForm" method="POST" enctype="multipart/form-data">
                        <div class="border-bottom h2 py-2 mb-3">
                            <span id="product_name_display"><?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?></span>
                            <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?>" style="display: none;">
                        </div>
                        <table class="table table-bordered align-middle">
                            <tr class="">
                                <th class="col-2 py-3 text-center">品牌</th>
                                <td class="px-4"><?php echo htmlspecialchars($brandName, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">部位</th>
                                <td class="px-4"><?php echo htmlspecialchars($mainCategoryName, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">品項</th>
                                <td class="px-4"><?php echo htmlspecialchars($subCategoryName, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">色號</th>
                                <td class="px-4">
                                    <span id="color_name_display"><?php echo htmlspecialchars($colorName, ENT_QUOTES, 'UTF-8'); ?></span>
                                    <input type="text" name="color_name" id="color_name" value="<?php echo htmlspecialchars($colorName, ENT_QUOTES, 'UTF-8'); ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">價格</th>
                                <td class="price px-4">
                                    <span id="price_display"><?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?> 元</span>
                                    <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">庫存</th>
                                <td class="stock px-4">
                                    <span id="stock_display"><?php echo htmlspecialchars($stock, ENT_QUOTES, 'UTF-8'); ?> 件</span>
                                    <input type="text" name="stock" id="stock" value="<?php echo htmlspecialchars($stock, ENT_QUOTES, 'UTF-8'); ?>" style="display: none;">
                                </td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">商品描述</th>
                                <td class="px-4 py-2">
                                    <span id="description_display"><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></span>
                                    <textarea name="description" id="description" style="display: none;"><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                                </td>
                            </tr>
                            <tr id="image-upload-row" style="display: none;">
                                <th class="py-3 text-center">更換圖片</th>
                                <td class="px-4"><input type="file" name="product_image" id="product_image" accept="image/*"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <div class="success-message">保存成功！</div>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const editButton = document.querySelector('.edit-button');
        const saveButton = document.querySelector('.save-button');
        const imageUploadRow = document.getElementById('image-upload-row');

        editButton.addEventListener('click', function() {
            // 切換為編輯模式
            document.querySelectorAll('#productForm span').forEach(span => {
                span.style.display = 'none';
            });
            document.querySelectorAll('#productForm input, #productForm textarea').forEach(input => {
                input.style.display = 'block';
            });
            imageUploadRow.style.display = 'table-row'; // 顯示文件上傳輸入框
        });

        $('#productForm').on('submit', function(e) {
            e.preventDefault(); // 阻止表單默認提交

            const formData = new FormData(this); // 使用FormData對象來處理文件上傳

            $.ajax({
                url: window.location.href, // 提交到當前頁面
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // 重新加載頁面以顯示最新的數據
                    location.reload();
                }
            });
        });
    </script>
</body>

</html>