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
}

// 更新資料庫中的商品數據
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedProductName = $_POST['product_name'];
    $updatedColorName = $_POST['color_name'];
    $updatedPrice = $_POST['price'];
    $updatedDescription = $_POST['description'];
    $updatedStock = $_POST['stock'];

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

    echo "<script>alert('商品資料已更新成功！'); window.location.href='product.php?id=$productId&color_id=$colorId';</script>";
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
                    <a href="product_list.php" class="btn btn-dark reverse py-2 "><i class="fa-solid fa-chevron-left fa-fw "></i></a>
                </div>
                <div d-flex>
                    <a class="btn btn-dark py-2 me-2" href="#"><i class="fa-solid fa-pen edit-button fa-fw"></i></a> <!-- 編輯按鈕 -->
                    <button type="submit" class="save-button btn btn-dark py-2"><i class="fa-solid fa-cloud-arrow-down fa-fw "></i>
                    </button>
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

                    <form id="productForm">
                        <div class="border-bottom h2 py-2 mb-3">
                            <td contenteditable="false" id="product_name"><?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?></td>
                        </div>
                        <table class="table table-bordered align-middle">

                            <tr class="">
                                <th class="col-2 py-3 text-center ">品牌</th>
                                <td class="px-4"><?php echo htmlspecialchars($brandName, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">部位</th>
                                <td class="px-4"><?php echo htmlspecialchars($mainCategoryName, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center ">品項</th>
                                <td class="px-4"><?php echo htmlspecialchars($subCategoryName, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">色號</th>
                                <td class="px-4" contenteditable="false" id="color_name"><?php echo htmlspecialchars($colorName, ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">價格</th>
                                <td class="price px-4" contenteditable="false" id="price"><?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?> 元</td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">庫存</th>
                                <td class="stock px-4" contenteditable="false" id="stock"><?php echo htmlspecialchars($stock, ENT_QUOTES, 'UTF-8'); ?> 件</td>
                            </tr>
                            <tr>
                                <th class="py-3 text-center">商品描述</th>
                                <td class="px-4 py-2" contenteditable="false" id="description"><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></td>
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
        const contentEditableElements = document.querySelectorAll('[contenteditable="false"]');
        const successMessage = document.querySelector('.success-message');

        editButton.addEventListener('click', function() {
            contentEditableElements.forEach(element => {
                element.setAttribute('contenteditable', 'true');
                element.style.borderBottom = "1px solid #ddd";
            });
            //saveButton.style.display = 'block';
        });

        $('#productForm').on('submit', function(e) {
            e.preventDefault(); // 阻止表單默認提交

            const formData = {
                product_name: $('#product_name').text(),
                color_name: $('#color_name').text(),
                price: $('#price').text(),
                description: $('#description').text(),
                stock: $('#stock').text()
            };

            $.ajax({
                url: '', // 留空表示提交到當前頁面
                type: 'POST',
                data: formData,
                success: function(response) {
                    // 隱藏保存按鈕
                    saveButton.style.display = 'none';

                    // 顯示成功消息
                    //successMessage.style.display = 'block';
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 2000);

                    // 取消編輯狀態
                    contentEditableElements.forEach(element => {
                        element.setAttribute('contenteditable', 'false');
                        element.style.borderBottom = "none";
                    });
                }
            });
        });
    </script>
</body>

</html>