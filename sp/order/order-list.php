<?php
// 使用mysql
require_once("../../db_connect.php");

$whereClause = "WHERE user_order.valid = 1 ";


$sqlorderAll = "SELECT * FROM user_order WHERE valid = 1";
$resulorderAll = $conn->query($sqlorderAll);
$orderCountAll = $resulorderAll->num_rows;

$sqlpayAll = "SELECT * FROM user_order WHERE pay_id = 1 AND valid = 1";
$resulpayAll = $conn->query($sqlpayAll);
$payCountAll = $resulpayAll->num_rows;

$sqlstatusAll = "SELECT * FROM user_order WHERE status_id = 1 AND valid = 1";
$resulstatusAll = $conn->query($sqlstatusAll);
$statusCountAll = $resulstatusAll->num_rows;



// 換頁

// 頁碼和每頁顯示數量
$page = isset($_GET["p"]) ? intval($_GET["p"]) : 1;
$per_page = 7;
$start_item = ($page - 1) * $per_page;

// 總頁數
$total_Page = ceil($orderCountAll / $per_page);
$searchType = isset($_GET["search_type"]) ? $_GET["search_type"] : '';

// 篩選條件
if (isset($_GET["search_type"]) || isset($_GET["date"]) || isset($_GET["start"]) || isset($_GET["end"]) || isset($_GET["pay"]) || isset($_GET["status"])) {
    if (isset($_GET["search"]) && !empty($_GET["search"])) {
        $search = $conn->real_escape_string($_GET["search"]);
        if ($searchType == "1") {
            // 搜尋訂單編號
            $whereClause .= " AND user_order.id LIKE '%$search%'";
        } elseif ($searchType == "2") {
            // 搜尋訂購者名稱
            $whereClause .= " AND users.name LIKE '%$search%'";
        }
    }
    if (isset($_GET["date"])) {
        $date = $conn->real_escape_string($_GET["date"]);
        $whereClause .= " AND user_order.order_date = '$date'";
    }
    if (isset($_GET["start"]) && isset($_GET["end"])) {
        $start = $conn->real_escape_string($_GET["start"]);
        $end = $conn->real_escape_string($_GET["end"]);
        $whereClause .= " AND user_order.order_date BETWEEN '$start' AND '$end'";
    }
    if (isset($_GET["pay"])) {
        $pay = $conn->real_escape_string($_GET["pay"]);
        $whereClause .= " AND user_order.pay_id = '$pay'";
        $total_Page = ceil($payCountAll / $per_page);
    }
    if (isset($_GET["status"])) {
        $status = $conn->real_escape_string($_GET["status"]);
        $whereClause .= " AND user_order.status_id = '$status'";
        $total_Page = ceil($statusCountAll / $per_page);
    }
} else {
    $whereClause .= "";
}

// 默认排序字段和方向
$sortField = 'user_order.id';
$sortDirection = 'DESC';

// 如果 GET 请求中有排序字段和方向参数
if (isset($_GET['sort_field']) && isset($_GET['sort_direction'])) {
    $sortField = $_GET['sort_field'];
    $sortDirection = $_GET['sort_direction'];
}


$sql = "SELECT user_order.*, 
product_list.product_name AS product_name, 
product_list.price AS price, 
users.name AS user_name,
pay.name as pay_name,
status.name as status_name
FROM user_order 
JOIN product_list ON user_order.product_id = product_list.id
JOIN users ON user_order.user_id = users.id
JOIN pay ON user_order.pay_id = pay.id
JOIN status ON user_order.status_id = status.id
$whereClause
ORDER BY $sortField $sortDirection

-- ORDER BY user_order.id DESC
LIMIT $start_item, $per_page";
$result = $conn->query($sql);

?>

<!doctype html>
<html lang="en">



<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bootstrap Dashboard</title>
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

    <main class="main-content">
        <div class="pt-4 px-5">
            <div class="d-flex justify-content-between align-items-start ">
                <!-- 返回 order-list 的按鈕 -->
                <?php if (isset($_GET["date"]) || isset($_GET["user"]) || isset($_GET["product"])) : ?>
                    <div class="col-auto">
                        <a class="btn btn-primary" href="order-list.php"><i class="fa-solid fa-left-long"></i></a>
                    </div>
                <?php endif; ?>

                <!-- header 標題 -->
                <div class="col">
                    <p class="m-0 d-inline text-lg text-secondary">訂單管理 /
                        <span class="text-sm">訂單列表</span>
                    </p>
                    <hr>
                </div>
            </div>



            <!-- 照狀態分類 -->
            <div class="col-12 mt-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if (!isset($_GET["pay"]) && !isset($_GET["status"])) echo "active" ?>" aria-current="page" href="order-list.php?p=1">全部 <?= $orderCountAll ?></a>
                        <!-- ?p=<?= $_GET["p"] ?> -->
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php if (isset($_GET["pay"]) == 1) echo "active" ?> " href="order-list.php?p=<?= $page ?>&pay=1">未付款 <?= $payCountAll  ?></a>
                        <!-- p=<?= $_GET["p"] ?>& -->
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php if (isset($_GET["status"]) == 1) echo "active" ?> " href="order-list.php?p=<?= $page ?>&status=1">訂單處理中 <?= $statusCountAll ?></a>
                        <!-- p=<?= $_GET["p"] ?>& -->
                    </li>

                </ul>
            </div>



            <!-- 關鍵字搜尋 -->
            <div class="select d-flex align-items-center justify-content-between border-start border-end">
                <form class="d-flex my-3" method="GET">
                    <div class="col-5 ">
                        <select class="form-select rounded-start mx-2" name="search_type" aria-label="Default select example">
                            <option selected>搜尋關鍵字</option>
                            <option value="1" <?php if ($searchType == "1") echo "selected"; ?>>訂單編號</option>
                            <option value="2" <?php if ($searchType == "2") echo "selected"; ?>>訂購者名稱</option>
                        </select>
                    </div>
                    <div class="col-8 me-1">
                        <div class="input-group ">
                            <input type="search" class="form-control rounded-0" name="search" value="<?php echo isset($_GET["search"]) ? htmlspecialchars($_GET["search"]) : "" ?>" placeholder="搜尋">
                            <button class="btn btn-primary rounded-end" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>


                <!-- 日期篩選 -->
                <?php if (!isset($_GET["date"])): ?>
                    <div class="mx-3 my-3 ">
                        <form action="">
                            <?php
                            $today = date('Y-m-d');
                            $start = isset($_GET["start"]) ? $_GET["start"] : $today;
                            $end = isset($_GET["end"]) ? $_GET["end"] : $today;
                            ?>
                            <div class="row g-2">
                                <?php if (isset($_GET["start"])) : ?>
                                    <div class="col-auto">
                                        <a class="btn btn-primary" href="order-list.php"><i class="fa-solid fa-left-long"></i></a>
                                    </div>
                                <?php endif; ?>
                                <div class="col-auto">
                                    <input type="date" class="form-control" name="start" value="<?= $start ?>" id="start-date">
                                </div>
                                <div class="col-auto">
                                    ~
                                </div>
                                <div class="col-auto">
                                    <input type="date" class="form-control" name="end" value="<?= $end ?>" id="end-date">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>


            <?php if ($orderCountAll > 0) :
                $rows = $result->fetch_all(MYSQLI_ASSOC);
            ?>

                <table class="table border table-hover"> <!-- table-bordered -->
                    <thead class="table-light text-center">
                        <tr>
                            <th>訂單編號</th>
                            <th>訂單日期</th>
                            <th>付款狀態</th>
                            <th>訂單狀態</th>
                            <th>訂購人</th>
                            <th>合計</th>
                            <th>明細</th>
                            <th>刪除</th>

                        </tr>

                    </thead>
                    <tbody class="text-center">
                        <?php
                        $total = 0;
                        foreach ($rows as $order) : ?>
                            <tr class="">
                                <td><?= $order["number"] ?></td>
                                <td><?= $order["order_date"] ?></td>
                                <td><?= $order["pay_name"] ?></td>
                                <td><?= $order["status_name"] ?></td>
                                <td><?= $order["user_name"] ?></td>
                                <?php
                                $subtotal = $order["price"] * $order["amount"];
                                $total += $subtotal
                                ?>
                                <td class=""><?= number_format($subtotal) ?></td>

                                <!-- class="btn btn-outline-secondary " -->
                                <td><a class="btn btn-outline-secondary " href="order.php?id=<?= $order["id"] ?>"><i class="fa-solid fa-file-lines "></i></a>
                                </td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= urlencode($order["id"]) ?> ">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content ">
                                                <div class="modal-body">
                                                    <h1 class="modal-title py-3 text-center" id="exampleModalLabel">確定要刪除此筆資料</h1>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                    <button type="button" class="btn btn-primary" id="confirmDelete">確定</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <nav aria-label="Page navigation example ">
                    <ul class="pagination justify-content-center mt-5">
                        <?php if (isset($_GET["p"]) && isset($_GET["pay"])): ?>
                            <?php $payPage = ceil($payCountAll / $per_page);
                            for ($i = 1; $i <= $payPage; $i++) : ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link " href="order-list.php?p=<?= $i ?>&pay=1"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        <?php endif; ?>
                        <?php if (isset($_GET["p"]) && isset($_GET["status"])): ?>
                            <?php $staPage = ceil($statusCountAll / $per_page);
                            for ($i = 1; $i <= $staPage; $i++) : ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link " href="order-list.php?p=<?= $i ?>&status=1"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        <?php endif; ?>
                        <?php if (isset($_GET["p"]) && !isset($_GET["status"]) && !isset($_GET["pay"])): ?>
                            <?php $orderPage = ceil($orderCountAll / $per_page);
                            for ($i = 1; $i <= $orderPage; $i++) : ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link " href="order-list.php?p=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        <?php endif; ?>


                    </ul>
                </nav>
            <?php else : ?>
                目前沒有訂單
            <?php endif; ?>
        </div>
    </main>




    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../js/front.js"></script> -->
    <script>
        // 儲存刪除 URL 的變量
        let deleteUrl = '';

        // 當點擊觸發 Modal 的按鈕時，儲存刪除 URL
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                deleteUrl = 'doDeleteOrder.php?id=' + encodeURIComponent(this.getAttribute('data-id'));
            });
        });

        // 當點擊“確定”按鈕時，執行刪除操作
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteUrl) {
                window.location.href = deleteUrl;
            }
        });



        // 获取日期选择器
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');

        // 监听 start 日期的变化
        startDateInput.addEventListener('change', function() {
            const startDate = startDateInput.value;
            if (startDate) {
                // 设置 end 日期选择器的最小值为 start 日期
                endDateInput.min = startDate;
            }
        });

        // 初始设置 end 日期选择器的最小值为 start 日期
        endDateInput.min = startDateInput.value;
    </script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>