<?php
// 使用mysql
require_once("../../db_connect.php");

$whereClause = "WHERE user_order.valid = 1 ";

// 換頁
// $page = 1;
// $start_item = 0;
// $per_page = 4;

// $total_Page = ceil($orderCountAll / $per_page);

// if (isset($_GET["p"]) ) {

//     $page = $_GET["p"];
//     $start_item = ($page - 1) * $per_page;
//     $whereClause .= "";
//     $where_clause = "ORDER BY user_order.order_date DESC";


//     $sql = "SELECT * FROM user_order WHERE valid = 1 $where_clause LIMIT $start_item,$per_page ";

//     // $sql = "SELECT * FROM users WHERE valid = 1 LIMIT $start_item,$per_page";
// } 
// else {

//     header("location: order-list.php?p=1");
//     // $sql = "SELECT * FROM users WHERE valid = 1 LIMIT $start_item,$per_page";
// }


// 篩選條件
if (isset($_GET["date"])) {
    $date = $_GET["date"];
    $whereClause .= "AND user_order.order_date = '$date'";
} elseif (isset($_GET["start"]) && isset($_GET["end"])) {
    $start = $_GET["start"];
    $end = $_GET["end"];
    $whereClause .= "AND user_order.order_date BETWEEN '$start' AND '$end'";
} else if (isset($_GET["pay"])) {
    $pay = $_GET["pay"];
    $whereClause .= "AND user_order.pay_id = '$pay'";
} else if (isset($_GET["status"])) {
    $status = $_GET["status"];
    $whereClause .= "AND user_order.status_id = '$status'";
} else {
    $whereClause .= "";
}


// 搜尋欄位
$searchType = isset($_GET["search_type"]) ? $_GET["search_type"] : '';
if (isset($_GET["search"]) && !empty($_GET["search"])) {
    $search = $conn->real_escape_string($_GET["search"]);
    if ($searchType == "1") {
        // 搜尋訂單編號
        $whereClause .= "AND user_order.id LIKE '%$search%'";
    } elseif ($searchType == "2") {
        // 搜尋訂購者名稱
        $whereClause .= "AND users.name LIKE '%$search%'";
    }
}






$sqlorderAll = "SELECT * FROM user_order WHERE valid = 1";
$resulorderAll = $conn->query($sqlorderAll);
$orderCountAll = $resulorderAll->num_rows;

$sqlpayAll = "SELECT * FROM user_order WHERE pay_id = 1 AND valid = 1";
$resulpayAll = $conn->query($sqlpayAll);
$payCountAll = $resulpayAll->num_rows;

$sqlstatusAll = "SELECT * FROM user_order WHERE status_id = 1 AND valid = 1";
$resulstatusAll = $conn->query($sqlstatusAll);
$statusCountAll = $resulstatusAll->num_rows;



$sql = "SELECT user_order.*, 
product_list.product_name AS product_name, 
product_list.price, 
users.name AS user_name,
pay.name as pay_name,
status.name as status_name
FROM user_order 
JOIN product_list ON user_order.product_id = product_list.id
JOIN users ON user_order.user_id = users.id
JOIN pay ON user_order.pay_id = pay.id
JOIN status ON user_order.status_id = status.id
$whereClause
ORDER BY user_order.order_date DESC
";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);



?>

<!doctype html>
<html lang="en">

<!-- -- ORDER BY user_order.order_date DESC
-- LIMIT $start_item, $per_page -->


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
            </div>
        </div>



        <!-- 照狀態分類 -->
        <div class="col-12 mt-3">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?php if (!isset($_GET["pay"]) && !isset($_GET["status"])) echo "active" ?>" aria-current="page" href="order-list.php">全部 <?= $orderCountAll ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if (isset($_GET["pay"]) == 1) echo "active" ?> " href="order-list.php?pay=1">未付款 <?= $payCountAll  ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if (isset($_GET["status"]) == 1) echo "active" ?> " href="order-list.php?status=1">訂單處理中 <?= $statusCountAll ?></a>
                </li>

            </ul>
        </div>



        <!-- 關鍵字搜尋 -->
        <div class="select d-flex align-items-center justify-content-between border-start border-end">
            <form class="d-flex mt-3" method="GET">
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
            <?php if (!isset($_GET["product"]) && !isset($_GET["user"]) && !isset($_GET["date"])): ?>
                <div class="mx-3 mt-3 py-2">
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




        <table class="table border table-hover"> <!-- table-bordered -->
            <thead class="table-light">
                <tr>
                    <th>訂單編號
                        <button
                            type="button"
                            data-sort="id"
                            class="btn btn-outline-white btn-sm sort">
                            <i class="fa-solid fa-sort-down"></i>
                        </button>
                    </th>
                    <th>訂單日期
                        <button
                            type="button"
                            data-sort="order_date"
                            class="btn btn-outline-white btn-sm sort">
                            <i class="fa-solid fa-sort-down"></i>
                        </button>
                    </th>
                    <th>付款狀態</th>
                    <th>訂單狀態</th>
                    <th>訂購人</th>
                    <th>合計</th>
                    <th></th>
                    <th></th>

                </tr>

            </thead>
            <tbody class="">
                <?php
                $total = 0;
                foreach ($rows as $order) : ?>
                    <tr>
                        <td><?= $order["id"] ?></td>
                        <td><?= $order["order_date"] ?></td>
                        <td><?= $order["pay_name"] ?></td>
                        <td><?= $order["status_name"] ?></td>
                        <td><?= $order["user_name"] ?></td>
                        <?php
                        $subtotal = $order["price"] * $order["amount"];
                        $total += $subtotal
                        ?>
                        <td class="text-start"><?= number_format($subtotal) ?></td>
                        <td><a href="order.php?id=<?= $order["id"] ?>"><i class="fa-solid fa-file-lines"></i></a></td>
                        <td><a href=""><i class="fa-regular fa-trash-can"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <!-- <ul class="pagination">
                <?php for ($i = 1; $i <= $total_Page; $i++) : ?>
                    <li class="page-item"><a class="page-link" href="order-list.php?p=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>
            </ul> -->
        </nav>

    </main>




    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="../js/front.js"></script> -->
    <script>
   

        const sortButtons = document.querySelectorAll('.sort');
        sortButtons.forEach(button => {
            button.addEventListener('click', () => {

                const icon = button.querySelector('i');


                if (icon.classList.contains('fa-sort-down')) {

                    icon.classList.remove('fa-sort-down');
                    icon.classList.add('fa-sort-up');
                } else {

                    icon.classList.remove('fa-sort-up');
                    icon.classList.add('fa-sort-down');
                }
            });
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