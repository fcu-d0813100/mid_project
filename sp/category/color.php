<?php

require_once("./productdb_connect.php");

$itemsPerPage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;


$order = isset($_GET['order']) ? $_GET['order'] : 'asc';


if ($order !== 'asc' && $order !== 'desc') {
    $order = 'asc';
}
$search = '';
$lowStock = isset($_GET['low_stock']) ? intval($_GET['low_stock']) : 0;
if (isset($_GET["search"])) {
    $search = $conn->real_escape_string($_GET["search"]);
}

$filter = '';
if ($lowStock) {
    $filter = "AND color.stock < 35";
}

// 檢查是否有搜索關鍵字
if (isset($_GET["search"])) {
    $sql = "SELECT color.id, color.product_id, color.color, color.stock, product_list.product_name
            FROM color 
            JOIN product_list ON color.product_id = product_list.id
            WHERE (color.color LIKE '%$search%' OR product_list.product_name LIKE '%$search%') 
            AND color.valid=1 $filter
            ORDER BY color.id $order
            LIMIT $offset, $itemsPerPage";
    $countSql = "SELECT COUNT(*) as total 
    FROM color 
    JOIN product_list ON color.product_id = product_list.id
    WHERE (color.color LIKE '%$search%' OR product_list.product_name LIKE '%$search%')
    AND color.valid=1 $filter";
} else {
    $sql = "SELECT color.id, color.product_id, color.color, color.stock, product_list.product_name
    FROM color 
    JOIN product_list ON color.product_id = product_list.id
    AND color.valid=1 $filter
    ORDER BY color.id $order
    LIMIT $offset, $itemsPerPage";
    $countSql = "SELECT COUNT(*) as total 
    FROM color 
    JOIN product_list ON color.product_id = product_list.id 
   AND color.valid=1 $filter";
}

$result = $conn->query($sql);
$colorCount = $result->num_rows;

// 獲取總記錄數
$countResult = $conn->query($countSql);
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $itemsPerPage);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>色號及庫存</title>
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
            <div class="py-3">
                <p class="m-0 d-inline text-lg text-secondary">類別管理 /<span class="text-sm">色號及庫存</span></p>
            </div>
            <div class="py-2">
                <?php if (isset($_GET["search"])) : ?>
                    <a class="btn btn-primary" href="color.php" title="回列表"><i class="fa-solid fa-left-long"></i> 返回列表</a>
                <?php endif; ?>
            </div>
            <form action="">
                <div class="input-group">
                    <input type="search" class="form-control" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋商品名稱或色號">
                    <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <div class="py-3 d-flex justify-content-between">
                <a class="btn btn-primary" href="create-color.php"><i class="fa-solid fa-plus"></i>新增色號及庫存</a>
                <div class="btn-group">
                    <a class="btn btn-primary" href="color.php?order=asc<?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
                        <i class="fa-solid fa-arrow-down-1-9"></i> ID正序
                    </a>
                    <a class="btn btn-primary" href="color.php?order=desc<?= isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '' ?>">
                        <i class="fa-solid fa-arrow-down-9-1"></i> ID倒序
                    </a>
                    <a class="btn btn-secondary" href="color.php<?= isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) . '&low_stock=1' : '?low_stock=1' ?>">
                        <i class="fa-solid fa-filter"></i>庫存過低
                    </a>
                    <a class="btn btn-secondary" href="color.php<?= isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : '' ?>">
                        <i class="fa-solid fa-layer-group"></i>全部商品
                    </a>
                </div>
            </div>


            <?php if ($colorCount > 0) :
                $rows = $result->fetch_all(MYSQLI_ASSOC);
            ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>商品編號</th>
                            <th>商品名稱</th>
                            <th>色號</th>
                            <th>庫存</th>
                            <th>修改刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $color) : ?>
                            <tr>
                                <td><?= $color["id"] ?></td>
                                <td><?= $color["product_name"] ?></td>
                                <td><?= $color["color"] ?></td>
                                <td><?= $color["stock"] ?> <?php if ($color["stock"] < 35) : ?>
                                        <span class="text-danger">庫存過低</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="color-edit.php?id=<?= $color["id"] ?>">修改</a>
                                    <a class="btn btn-danger" href="doDeleteColor.php?id=<?= $color['id'] ?>"
                                        onclick="return confirm('是否確定刪除?')">刪除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">&laquo;</a>
                        </li>

                        <?php
                        if ($totalPages > 1) {
                            $showPages = 5; // 可見的頁碼數量
                            $startPage = max(1, min($page - floor($showPages / 2), $totalPages - $showPages + 1));
                            $endPage = min($totalPages, $startPage + $showPages - 1);

                            if ($startPage > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($_GET, ['page' => 1])) . '">1</a></li>';
                                if ($startPage > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }

                            for ($i = $startPage; $i <= $endPage; $i++) {
                                echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?' . http_build_query(array_merge($_GET, ['page' => $i])) . '">' . $i . '</a></li>';
                            }

                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($_GET, ['page' => $totalPages])) . '">' . $totalPages . '</a></li>';
                            }
                        }
                        ?>

                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>

        </div>
    <?php else : ?>
        <div class="alert alert-warning">沒有找到相關產品</div>
    <?php endif; ?>
    </main>
    <?php $conn->close(); ?>
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