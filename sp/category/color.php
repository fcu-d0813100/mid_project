<?php
require_once("./productdb_connect.php");

// 确定当前页码，并确保它是有效的整数
$page = isset($_GET["p"]) ? (int)$_GET["p"] : 1;
$page = $page > 0 ? $page : 1; // 确保页码不为负数
$per_page = 12; // 每页显示的项目数量
$start_item = ($page - 1) * $per_page;

// 确定排序方式
$order = isset($_GET["order"]) ? (int)$_GET["order"] : 1;
$filterLowStock = isset($_GET["low_stock"]) ? (int)$_GET["low_stock"] : 0; // 新增筛选库存过低的条件

switch ($order) {
    case 1:
        $order_clause = "ORDER BY color.id ASC";
        break;
    case 2:
        $order_clause = "ORDER BY color.id DESC";
        break;
    default:
        $order_clause = "ORDER BY color.id ASC";
        break;
}

// 搜索关键字
$search = isset($_GET["search"]) ? $conn->real_escape_string($_GET["search"]) : '';
$product_id = isset($_GET["product_id"]) ? (int)$_GET["product_id"] : 0;

// 计算符合搜索条件的总库存量
$sqlTotalStock = "SELECT SUM(stock) as total_stock FROM color
                   JOIN product ON color.product_id = product.id
                   WHERE (color.color LIKE '%$search%' OR product.product_name LIKE '%$search%')
                   AND ($product_id = 0 OR color.product_id = $product_id)
                   AND color.deleted_at IS NULL";

// 根据搜索关键字和产品 ID 修改 SQL 查询
if ($search || $product_id || $filterLowStock) {
    $sqlAll = "SELECT COUNT(*) as total FROM color
               JOIN product ON color.product_id = product.id
               WHERE (color.color LIKE '%$search%' OR product.product_name LIKE '%$search%')
               AND ($product_id = 0 OR color.product_id = $product_id)
               AND color.deleted_at IS NULL";

    if ($filterLowStock) {
        $sqlAll .= " AND color.stock < 30";
    }

    $sql = "SELECT color.id, product.product_name, color.color, color.stock
            FROM color
            JOIN product ON color.product_id = product.id
            WHERE (color.color LIKE '%$search%' OR product.product_name LIKE '%$search%')
            AND ($product_id = 0 OR color.product_id = $product_id)
            AND color.deleted_at IS NULL";

    if ($filterLowStock) {
        $sql .= " AND color.stock < 30";
    }

    $sql .= " $order_clause
              LIMIT $start_item, $per_page";
} else {
    $sqlAll = "SELECT COUNT(*) as total FROM color
               JOIN product ON color.product_id = product.id
               WHERE color.deleted_at IS NULL";

    $sql = "SELECT color.id, product.product_name, color.color, color.stock
            FROM color
            JOIN product ON color.product_id = product.id
            WHERE color.deleted_at IS NULL";

    if ($filterLowStock) {
        $sqlAll .= " AND color.stock < 30";
        $sql .= " AND color.stock < 30";
    }

    $sql .= " $order_clause
              LIMIT $start_item, $per_page";
}

// 获取总项目数
$resultAll = $conn->query($sqlAll);

if ($resultAll) {
    $row = $resultAll->fetch_assoc();
    $subCountAll = $row['total'];
} else {
    die("Error: " . $conn->error);
}

// 计算总页数
$total_page = ceil($subCountAll / $per_page);

// 查询当前页面数据
$result = $conn->query($sql);

if (!$result) {
    die("Error: " . $conn->error);
}

// 计算符合搜索条件的总库存量
$resultTotalStock = $conn->query($sqlTotalStock);

if ($resultTotalStock) {
    $rowTotalStock = $resultTotalStock->fetch_assoc();
    $totalStock = $rowTotalStock['total_stock'];
} else {
    die("Error: " . $conn->error);
}

// 获取产品列表
$products = $conn->query("SELECT DISTINCT id, product_name FROM product");

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>色號庫存</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../css/style.default.premium.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../css/custom.css">
    <!-- font-awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content ">
        <div class="container">
            <h3>色號庫存管理</h3>
            <div class="py-2">
                <?php if ($search || $filterLowStock) : ?>
                    <a class="btn btn-primary" href="color.php"><i class="fa-solid fa-left-long"></i> 回列表</a>
                <?php endif; ?>
            </div>
            <div class="py-2">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="search" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="搜尋產品名稱或顏色">
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>

            <div class="py-2 d-flex justify-content-between">
                <a class="btn btn-primary" href="create-color.php"><i class="fa-solid fa-plus"></i> 新增色號及庫存</a>
                <div class="btn-group">
                    <a class="btn btn-primary <?= ($order == 1) ? "active" : "" ?>" href="color.php?p=<?= $page ?>&order=1&product_id=<?= $product_id ?>&search=<?= htmlspecialchars($search) ?>&low_stock=<?= $filterLowStock ?>">
                        <i class="fa-solid fa-arrow-down-1-9"></i> ID正序
                    </a>
                    <a class="btn btn-primary <?= ($order == 2) ? "active" : "" ?>" href="color.php?p=<?= $page ?>&order=2&product_id=<?= $product_id ?>&search=<?= htmlspecialchars($search) ?>&low_stock=<?= $filterLowStock ?>">
                        <i class="fa-solid fa-arrow-down-9-1"></i> ID倒序
                    </a>
                    <a class="btn btn-secondary <?= ($filterLowStock == 1) ? "active" : "" ?>" href="color.php?p=<?= $page ?>&order=<?= $order ?>&product_id=<?= $product_id ?>&search=<?= htmlspecialchars($search) ?>&low_stock=1">
                        <i class="fa-solid fa-filter"></i> 庫存過低
                    </a>
                    <a class="btn btn-secondary <?= ($filterLowStock == 0 && !$search) ? "active" : "" ?>" href="color.php?p=<?= $page ?>&order=<?= $order ?>">
                        <i class="fa-solid fa-recycle"></i> 顯示全部
                    </a>
                </div>
            </div>
            <?php if ($subCountAll > 0) :
                $rows = $result->fetch_all(MYSQLI_ASSOC);
            ?>
                共有 <?= $totalStock ?> 個庫存
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>編號</th>
                            <th>產品名稱</th>
                            <th>顏色</th>
                            <th>庫存量</th>
                            <th>修改刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $color) : ?>
                            <tr>
                                <td><?= $color["id"] ?></td>
                                <td><?= htmlspecialchars($color["product_name"]) ?></td>
                                <td><?= htmlspecialchars($color["color"]) ?></td>
                                <td>
                                    <?= htmlspecialchars($color["stock"]) ?>
                                    <?php if ($color["stock"] < 30) : ?>
                                        <span class="text-danger">庫存過低</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="color-edit.php?id=<?= $color["id"] ?>">修改</a>
                                    <a class="btn btn-danger" href="doDeleteColor.php?id=<?= $color["id"] ?>" onclick="return confirm('確定要刪除該筆資料嗎？');">刪除</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (!$search) : ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                                <li class="page-item <?= ($page == $i) ? "active" : "" ?>">
                                    <a class="page-link" href="color.php?p=<?= $i ?>&order=<?= $order ?>&product_id=<?= $product_id ?>&search=<?= htmlspecialchars($search) ?>&low_stock=<?= $filterLowStock ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else : ?>
                目前沒有顏色庫存
            <?php endif; ?>
        </div>
    </main>


    </div>


    <script>
        function sortTable(orderType) {
            var page = <?= $page ?>;
            var url = "article-list.php?p=" + page + "&order=" + orderType;
            window.location.href = url;
        }
    </script>


    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>
<?php $conn->close(); ?>