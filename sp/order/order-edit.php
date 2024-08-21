<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";  //id 之後都要改成number訂單編號
    exit;
}

$id = $_GET["id"];

// 使用mysql
require_once("../../db_connect.php");

$sql = "SELECT *,
 product_list.product_name AS product_name, 
 product_list.price as price,
 product_list.color_id AS color_id, 
 product_list.images_id AS product_img,
 users.name AS user_name, 
 users.email AS user_email, 
 users.phone AS user_phone, 
 users.address AS user_address,
 pay.name AS pay_name,
 status.name AS status_name,
 color.color AS color
 
FROM user_order 
JOIN product_list ON user_order.product_id = product_list.id
JOIN users ON user_order.user_id = users.id
JOIN pay ON user_order.pay_id = pay.id
JOIN status ON user_order.status_id = status.id
JOIN color ON product_list.color_id = color.id 
WHERE user_order.id='$id' AND user_order.valid=1
";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sqlorderAll = "SELECT * FROM user_order WHERE valid = 1";
$resulorderAll = $conn->query($sqlorderAll);
$orderCountAll = $resulorderAll->num_rows;


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


    <header class="py-4">
        <?php include("../../nav1.php") ?>

        <main class="main-content">
            <div class="pt-5 px-5 mx-5">
                <div class="d-flex justify-content-start align-items-center">
                   
                    <p class="m-0 d-inline text-lg text-secondary">訂單明細 /<span class="text-sm">#<?= $_GET["id"] ?></span></p>
                </div>

                <!-- table-->
                <div class="py-2 d-flex justify-content-end gap-2">
                    <a href="order.php?id=<?= $_GET["id"] ?>" class="btn btn-outline-secondary"> <i class="fa-solid fa-arrow-left"></i>
                        取消
                    </a>
                    <a href="order.php?id=<?= $_GET["id"] ?>" class="btn btn-outline-secondary justify-content-end"> <i class="fa-solid fa-floppy-disk"></i>
                        儲存
                    </a>
                </div>

                <div class="d-flex align-items-center justify-content-between p-3 border mb-3 " action="doUpdateOrder.php" method="post">
                    <p class="m-0 d-inline text-lg text-secondary"><span class="text-lg">訂單編號#<?= $_GET["id"] ?></span></p>
                    <div class="d-flex align-items-center justify-content-between col-6">
                        <div>
                            <p>付款狀態</p>
                            <select class="form-select" aria-label="Default select example" name="pay">
                                <option selected><?= $row["pay_name"] ?></option>
                                <option value="1">未付款</option>
                                <option value="2">已付款</option>
                            </select>
                        </div>
                        <div>
                            <p>訂單狀態</p>
                            <select class="form-select" aria-label="Default select example" name="status">
                                <option selected><?= $row["status_name"] ?></option>
                                <option value="1">處理中</option>
                                <option value="2">已完成</option>
                            </select>
                        </div>
                        <div></div>
                    </div>
                </div>


                <table class="table "> <!-- table-bordered -->
                    <thead class="table-light">
                        <tr>
                            <th>商品圖片</th>
                            <th>名稱</th>
                            <th>規格</th>
                            <th>數量</th>
                            <th>價格</th>
                            <th>小計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        if ($orderCountAll > 0) : ?>
                            <tr>
                                <td><?= $row["product_img"] ?></td>
                                <td><?= $row["product_name"] ?></td>
                                <td><?= $row["color"] ?></td>
                                <td><?= $row["amount"] ?></td>
                                <td><?= $row["price"] ?></td>
                                <?php
                                $subtotal = $row["price"] * $row["amount"];
                                $total += $subtotal
                                ?>
                                <td class="text-start"><?= number_format($subtotal) ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="4 "></td>
                            <td>訂單總額：</td>
                            <td><?= number_format($subtotal) ?></td>
                        </tr>
                    </tbody>
                </table>




                <div class="d-flex align-items-center justify-content-start mt-5">
                    <div class="col-3">
                        <p class=" d-inline text-lg text-secondary border-bottom">會員資料</p>
                        <h5 class="mt-2 text-secondary">姓名：<?= $row["user_name"] ?></h5>
                        <h5 class="text-secondary">Email：<?= $row["user_email"] ?></h5>
                        <h5 class="text-secondary">手機：<?= $row["user_phone"] ?></h5>
                        <h5 class="text-secondary">地址：<?= $row["user_address"] ?></h5>
                    </div>
                </div>

            </div>

        </main>

        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="../js/front.js"></script> -->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </header>
</body>

</html>