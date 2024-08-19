<?php
require_once("../../db_connect.php");

if (isset($_GET["date"])) {
    $date = $_GET["date"];
    $title = $date;
    $whereClause = "WHERE user_order.order_date = '$date'";
} elseif (isset($_GET["user"])) {
    $user = $_GET["user"];
    // $title="";
    $whereClause = "WHERE user_order.user_id = '$user'";
} elseif (isset($_GET["product"])) {
    $product = $_GET["product"];
    // $title="";
    $whereClause = "WHERE user_order.product_id = '$product'";
} elseif (isset($_GET["start"]) && isset($_GET["end"])) {
    $start = $_GET["start"];
    $end = $_GET["end"];
    $title = "$start ~ $end";
    $whereClause = "WHERE user_order.order_date  BETWEEN '$start' AND '$end'";
} else {
    $title = "";
    $whereClause = "";
}

$sql = "SELECT user_order.*, product.name as product_name, product.price, users.name AS user_name
FROM user_order 
JOIN product ON user_order.product_id = product.id
JOIN users ON user_order.user_id = users.id
$whereClause
ORDER BY user_order.order_date DESC
";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_GET["user"])) {
    $title = $rows[0]["user_name"];
}
if (isset($_GET["product"])) {
    $title = $rows[0]["product_name"];
}

?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?>訂單列表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="row g-2 align-items-center mb-2">
            <?php if (isset($_GET["date"]) || isset($_GET["user"]) || isset($_GET["product"])) : ?>
                <div class="col-auto">
                    <a class="btn btn-primary" href="order-list.php"><i class="fa-solid fa-left-long"></i></a>
                </div>
            <?php endif; ?>
            <div class="col">
                <h1 class="m-0"><?= $title ?>訂單列表</h1>
            </div>
        </div>
        <?php if (!isset($_GET["product"]) && !isset($_GET["=user"]) && !isset($_GET["date"])) : ?>
            <div class="py-2">
                <form action="">
                    <?php
                    $today = date("Y-m-d");
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
                            <input type="date" class="form-control" name="start" value="<?= $start ?>">
                        </div>
                        <div class="col-auto">
                            ~
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" name="end" value="<?= $end ?>">
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>編號</th>
                    <th>日期</th>
                    <th>產品名稱</th>
                    <th>單價</th>
                    <th>數量</th>
                    <th>訂購者</th>
                    <th>總價</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><a href="?date=<?= $row["order_date"] ?>"><?= $row["order_date"] ?></a></td>
                        <td><a href="?product=<?= $row["product_id"] ?>"><?= $row["product_name"] ?></a></td>
                        <td class="text-end"><?= number_format($row["price"]) ?></td>
                        <td class="text-end"><?= $row["amount"] ?></td>
                        <td><a href="?user=<?= $row["user_id"] ?>"><?= $row["user_name"] ?></a></td>
                        <?php
                        $subtotal = $row["price"] * $row["amount"];
                        $total += $subtotal;
                        ?>
                        <td class="text-end"><?= number_format($subtotal) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-end">
            總計:<?= number_format($total) ?>
        </div>
    </div>
</body>

</html>