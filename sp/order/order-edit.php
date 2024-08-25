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
 users.name AS user_name, 
 users.email AS user_email, 
 users.phone AS user_phone, 
 users.address AS user_address,
 pay.id AS pay_id,
 pay.name AS pay_name,
 status.id AS status_id,
 status.name AS status_name,
 color.mainimage AS mainimage
 
FROM user_order 
JOIN product_list ON user_order.product_id = product_list.id
JOIN users ON user_order.user_id = users.id
JOIN pay ON user_order.pay_id = pay.id
JOIN status ON user_order.status_id = status.id
JOIN color ON product_list.id = color.product_id 
WHERE user_order.id='$id' AND user_order.valid=1
";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>編輯訂單</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <?php include("./css.php") ?>
</head>

<body>


    <header>
        <?php include("../../nav1.php") ?>

        <main class="main-content">
            <div class="container">
                <form action="doUpdateOrder.php" method="post">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="pt-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="m-0 d-inline h2">編輯訂單</p>
                            </div>
                            <!-- table-->
                            <div class="d-flex justify-content-end">
                                <a href="order.php?id=<?= $id ?>" class="btn btn-dark  me-2"> <i class="fa-solid fa-arrow-left"></i>
                                    取消
                                </a>
                                <button class="btn btn-dark" type="submit">
                                    <i class="fa-solid fa-floppy-disk"></i> 儲存
                                </button>
                            </div>

                        </div>



                        <div class="d-flex align-items-center justify-content-between p-3 px-4 border my-3">
                            <p class="m-0 d-inline text-lg text-secondary"><span class="text-lg">訂單編號 # <?= $row["number"] ?></span></p>
                            <div class="d-flex align-items-center justify-content-between col-6">

                                <div>
                                    <label for="name">付款狀態</label>
                                    <select class="form-select" aria-label="Default select example" name="pay_id">
                                        <option value="1" <?= $row["pay_id"] == "1" ? 'selected' : '' ?>>未付款</option>
                                        <option value="2" <?= $row["pay_id"] == "2" ? 'selected' : '' ?>>已付款</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="name">訂單狀態</label>
                                    <select class="form-select" aria-label="Default select example" name="status_id">
                                        <option value="1" <?= $row["status_id"] == "1" ? 'selected' : '' ?>>處理中</option>
                                        <option value="2" <?= $row["status_id"] == "2" ? 'selected' : '' ?>>已完成</option>
                                    </select>
                                </div>
                                <div></div>
                            </div>
                        </div>


                        <table class="table align-middle"> <!-- table-bordered -->
                            <thead class="table-light">
                                <tr>
                                    <th class="col-4">商品圖片</th>
                                    <th class="col-3">名稱</th>
                                    <th class="col-2">規格</th>
                                    <th class="col-1">數量</th>
                                    <th class="col-1">價格</th>
                                    <th class="col-1">小計</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                // if ($orderCountAll > 0) : 
                                ?>
                                <tr>
                                    <td class="activePic">
                                        <div class="ratio ratio-4x3">
                                            <img class="object-fit-contain p-3" src="./image/<?= $row["mainimage"] ?>" alt="">
                                        </div>
                                    </td>
                                    <td><?= $row["product_name"] ?></td>
                                    <td><?= $row["color"] ?></td>
                                    <td><?= $row["amount"] ?></td>
                                    <td><?= number_format($row["price"]) ?></td>
                                    <?php
                                    $subtotal = $row["price"] * $row["amount"];
                                    $total += $subtotal
                                    ?>
                                    <td class="text-start"><?= number_format($subtotal) ?></td>
                                </tr>
                                <?php
                                // endif; 
                                ?>
                                <tr>
                                    <td colspan="4 "></td>
                                    <td>訂單總額：</td>
                                    <td><?= number_format($subtotal) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex align-items-center justify-content-start mt-4">
                            <div class="col-3">
                                <p class="d-inline h3 border-bottom border-dark mb-5">會員資料</p>
                                <h5 class="mt-3 fs-5 text-secondary">姓名：<?= $row["user_name"] ?></h5>
                                <h5 class="fs-5 text-secondary">Email：<?= $row["user_email"] ?></h5>
                                <h5 class="fs-5 text-secondary">手機：<?= $row["user_phone"] ?></h5>
                                <h5 class="fs-5 text-secondary">地址：<?= $row["user_address"] ?></h5>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </main>

        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="../js/front.js"></script> -->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </header>
</body>

</html>