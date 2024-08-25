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
    <link rel="stylesheet" href="../css/style.default.premium.css" id="theme-stylesheet">
    <link rel="stylesheet" href="../css/custom.css" id="theme-stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- 新增的樣式 -->
    <style>
        .product-container {
            display: flex;
            align-items: flex-start;
            /* padding-left: 100px; */
            padding-top: 20%;
            position: relative;
            width: 115%;
            font-size: 20px;
        }


        .product-image {
            max-width: 400px;
            max-height: 400px;
            margin-right: 80px;
            border-radius: 10px;
            position: relative; 
            top: 50px;
        }

        .back-button {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 10;
            background-color: rgba(0, 0, 0, 0.5); /* 半透明背景 */
            color: white; /* 白色文字 */
            border-radius: 5px; /* 圓角 */
            padding: 5px 10px; /* 內間距 */
            text-decoration: none;
        }

        .edit-button
        {
            position: absolute;
            top: -50px;
            right: -50px;
            background-color: #393836;
            color: white;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }

        .save-button {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 60px;
            color: rgba(0, 0, 0, 0.5);
            padding: 15px;
            font-size: 30px;
            cursor: pointer;
            z-index: 10;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            flex-grow: 1; /* 使 product-details 撐滿剩餘的空間 */
        }

        .product-details p {
            margin-bottom: 10px;
            font-size: 18px;
            color: #555;
            display: flex;
            align-items: center;
            position: relative;
        }

        .product-details p strong {
            color: #333;
        }

        .price {
            font-size: 24px;
            color: red;
            font-weight: bold;
        }

        .stock {
            font-size: 18px;
            color: #555;
            margin-top: 10px;
        }

        .success-message {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 50px;
            z-index: 10;
        }
        .reverse {
            position: fixed;
            left: 13%;
            top: 10%;
            display: block;
            width: 40px;
            height: 40px;
            background-color: #a31e1f;
            color: #fff;
        }
        #productForm {
            margin-top: 50px;
        }
        .descriptiontxt {
            display:block;
        }
        form {
            position: relative;
            border-top: 1px solid #ccc;
            padding-top: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            white-space: nowrap; /* 防止換行 */
        }

        #product_name {
            position: absolute;
            top: -60px;
            font-size: 28px; /* 放大字體 */
            font-weight: bold; /* 加粗字體 */
            border: none;
        }
    </style>
</head>
<body>
    <?php include("../../nav1.php") ?>
    <main class="container">
        <div class="product-container">
            <?php if ($imageName): ?>
                <div class="product-image">
                    <img src="./uploads/<?php echo htmlspecialchars($imageName, ENT_QUOTES, 'UTF-8'); ?>" alt="商品圖片" style="width: 100%;">
                </div>
            <?php else: ?>
                <p>無圖片</p>
            <?php endif; ?>
            <div class="product-details">
                <a href="product_list.php" class="btn  reverse" ><i class="fa-solid fa-chevron-left"></i></a>
                <i class="fa-solid fa-pen edit-button"></i> <!-- 編輯按鈕 -->
                <form id="productForm">
                    <table>
                        <tr>
                            <td contenteditable="false" id="product_name"><?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>品牌</th>
                            <td><?php echo htmlspecialchars($brandName, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>部位</th>
                            <td><?php echo htmlspecialchars($mainCategoryName, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>品項</th>
                            <td><?php echo htmlspecialchars($subCategoryName, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>色號</th>
                            <td contenteditable="false" id="color_name"><?php echo htmlspecialchars($colorName, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>價格</th>
                            <td class="price" contenteditable="false" id="price"><?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8'); ?> 元</td>
                        </tr>
                        <tr>
                            <th>庫存</th>
                            <td class="stock" contenteditable="false" id="stock"><?php echo htmlspecialchars($stock, ENT_QUOTES, 'UTF-8'); ?> 件</td>
                        </tr>
                        <tr>
                            <th>商品描述</th>
                            <td contenteditable="false" id="description"><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    </table>
                    <button type="submit" class="save-button"><i class="fa-solid fa-cloud-arrow-down"></i></button>
                </form>
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
            saveButton.style.display = 'block';
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
                    successMessage.style.display = 'block';
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
