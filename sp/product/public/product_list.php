<?php 
include('../config/database.php');

// 每頁顯示的資料筆數
$limit = 12;

// 當前頁碼
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 計算資料查詢的起始位置
$offset = ($page - 1) * $limit;

// 初始化過濾器變數
$filter = "";

// SQL 查詢語句，首先獲取總數據條數以計算總頁數
$sql_count = "SELECT COUNT(*) FROM product_list";
if (isset($_GET['price_filter'])) {
    $filter = $_GET['price_filter'];
    if ($filter == 'under_1000') {
        $sql_count .= " WHERE price < 1000";
    } elseif ($filter == '1000_2000') {
        $sql_count .= " WHERE price BETWEEN 1000 AND 2000";
    } elseif ($filter == 'above_2000') {
        $sql_count .= " WHERE price > 2000";
    }
}

// 執行計算總數的查詢
$stmt = $pdo->query($sql_count);
$totalItems = $stmt->fetchColumn();

// 計算總頁數
$totalPages = ceil($totalItems / $limit);

// 每組顯示 5 個頁碼
$pagesPerGroup = 5;

// 計算當前頁碼所在的頁碼組
$currentGroup = ceil($page / $pagesPerGroup);

// 當前組的起始和結束頁碼
$startPage = ($currentGroup - 1) * $pagesPerGroup + 1;
$endPage = min($currentGroup * $pagesPerGroup, $totalPages);

// 處理新增商品的表單提交
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $brand_id = $_POST['brand_id'];
    $main_category_id = $_POST['main_category_id'];
    $sub_category_id = $_POST['sub_category_id'];
    $color_id = $_POST['color_id'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $images_id = $_POST['images_id'];

    $sql_insert = "INSERT INTO product_list (id, product_name, brand_id, main_category_id, sub_category_id, color_id, price, description, images_id)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([$id, $product_name, $brand_id, $main_category_id, $sub_category_id, $color_id, $price, $description, $images_id]);

    echo "<script>alert('商品已成功新增！'); window.location.href='product.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../css/style.default.premium.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../css/custom.css?v=1.0">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include("../../../nav1.php") ?>

<div class="main-content-wrapper">
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <p class="m-0 d-inline text-lg text-secondary">商品管理 /<span class="text-sm">商品列表</span></p>
            <!-- 新增商品按鈕 -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">新增商品</button>

        </div>
        <!-- 模態視窗 -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">新增商品</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="number" class="form-control" id="id" name="id" required>
                            </div>
                            <div class="form-group">
                                <label for="product_name">產品名稱:</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label for="brand_id">品牌 ID:</label>
                                <input type="number" class="form-control" id="brand_id" name="brand_id" required>
                            </div>
                            <div class="form-group">
                                <label for="main_category_id">主類別 ID:</label>
                                <input type="number" class="form-control" id="main_category_id" name="main_category_id" required>
                            </div>
                            <div class="form-group">
                                <label for="sub_category_id">子類別 ID:</label>
                                <input type="number" class="form-control" id="sub_category_id" name="sub_category_id" required>
                            </div>
                            <div class="form-group">
                                <label for="color_id">顏色 ID:</label>
                                <input type="number" class="form-control" id="color_id" name="color_id" required>
                            </div>
                            <div class="form-group">
                                <label for="price">價格:</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="description">描述:</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="images_id">圖片 ID:</label>
                                <input type="number" class="form-control" id="images_id" name="images_id" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-primary" name="add_product">新增</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <form method="GET" action="product.php" class="price-pagination-form">
            <!-- 分頁連結 -->
            <div class="pagination">
                <?php
                // Previous group button
                $prevGroupPage = 0; // 初始化變量
                if ($currentGroup > 1) {
                    $prevGroupPage = $startPage - 1;
                    echo "<a href='product_list.php?page=$prevGroupPage&price_filter=$filter'>Previous</a>";
                }

                // 顯示當前組的頁碼
                for ($i = $startPage; $i <= $endPage; $i++) {
                    if ($i == $page) {
                        echo "<strong>$i</strong>";
                    } else {
                        echo "<a href='product_list.php?page=$i&price_filter=$filter'>$i</a>";
                    }
                }

                // Next group button
                $nextGroupPage = 0; // 初始化變量
                if ($endPage < $totalPages) {
                    $nextGroupPage = $endPage + 1;
                    echo "<a href='product_list.php?page=$nextGroupPage&price_filter=$filter'>Next</a>";
                }
                ?>
            </div>
            <!-- 篩選表單 -->
            <div class="price-filter">
                <label for="price_filter">依價格篩選:</label>
                <select id="price_filter" name="price_filter">
                    <option value="">All</option>
                    <option value="under_1000" <?php if(isset($_GET['price_filter']) && $_GET['price_filter'] == 'under_1000') echo 'selected'; ?>>Under 1000</option>
                    <option value="1000_2000" <?php if(isset($_GET['price_filter']) && $_GET['price_filter'] == '1000_2000') echo 'selected'; ?>>1000 - 2000</option>
                    <option value="above_2000" <?php if(isset($_GET['price_filter']) && $_GET['price_filter'] == 'above_2000') echo 'selected'; ?>>Above 2000</option>
                </select>
                <input type="submit" value="Filter">
            </div>
        </form>

        <table>
    <tr>
        <th>編號</th>
        <th>產品名稱</th>
        <th>品牌</th>
        <th>部位</th>
        <th>品項</th>
        <th>色號</th>
        <th>價格</th>
        <th>商品</th>
        <th>操作</th>
    </tr>
    <?php
    // 獲取資料的查詢語句
    $sql = "SELECT p.id, p.product_name, b.name AS brand_name, mc.name AS main_category_name, sc.name AS sub_category_name, p.color_id, c.color AS color_name, p.price, p.images_id
            FROM product_list p
            JOIN brand b ON p.brand_id = b.id
            JOIN main_category mc ON p.main_category_id = mc.id
            JOIN sub_category sc ON p.sub_category_id = sc.id
            JOIN color c ON p.color_id = c.id";
    if (isset($_GET['price_filter'])) {
        if ($filter == 'under_1000') {
            $sql .= " WHERE p.price < 1000";
        } elseif ($filter == '1000_2000') {
            $sql .= " WHERE p.price BETWEEN 1000 AND 2000";
        } elseif ($filter == 'above_2000') {
            $sql .= " WHERE p.price > 2000";
        }
    }

    $sql .= " ORDER BY p.id ASC LIMIT $limit OFFSET $offset";

    // 執行查詢
    $stmt = $pdo->query($sql);
    
    // 顯示資料
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['brand_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['main_category_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['sub_category_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['color_name']) . "</td>";
        echo "<td>" . number_format($row['price']) . "</td>";
        echo "<td><a href='product.php?id=" . htmlspecialchars($row['images_id']) . "' class='btn btn-primary'>查看商品</a></td>";
        echo "<td>
                <a href='update.php?id=" . htmlspecialchars($row['id']) . "'>編輯</a> |
                <a href='delete.php?id=" . htmlspecialchars($row['id']) . "'>刪除</a>
              </td>";
        echo "</tr>";
    }
    ?>
</table>

    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
