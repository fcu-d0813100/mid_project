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
 pay.name AS pay_name,
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

$sqlorderAll = "SELECT * FROM user_order WHERE valid = 1";
$resulorderAll = $conn->query($sqlorderAll);
$orderCountAll = $resulorderAll->num_rows;




?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>訂單明細</title>
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
                <div class="pt-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <a href="order-list.php?p=1" class="btn btn-dark btn-md mx-2">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                            <p class="m-0 d-inline h2 ms-3">訂單明細 </p>
                        </div>
                        <div>
                            <a href="order-edit.php?id=<?= $_GET["id"] ?>" class="btn btn-dark me-2">
                                <i class="fa-regular fa-pen-to-square"></i> 編輯
                            </a>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= urlencode($_GET["id"]) ?> ">
                                <i class="fa-regular fa-file-excel"></i> 取消
                            </button>
                        </div>
                    </div>

                    <!-- table-->
                    <div class="py-2 d-flex justify-content-end gap-2">

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content ">
                                    <div class="modal-body">
                                        <h1 class="modal-title py-3 text-center" id="exampleModalLabel">確定要取消此筆訂單 <i class="fa-solid fa-triangle-exclamation text-lg" style="color: #f50000;"></i></h1>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                        <button type="button" class="btn btn-primary" id="confirmDelete">確定</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-2 px-4 border mb-3">
                        <p class="m-0 d-inline text-lg text-secondary"><span class="text-lg">訂單編號 # <?= $row["number"] ?></span></p>
                        <div class="d-flex align-items-center justify-content-between col-6">
                            <div>
                                <p>付款狀態</p>
                                <div><?= $row["pay_name"] ?></div>
                            </div>
                            <div>
                                <p>訂單狀態</p>
                                <div><?= $row["status_name"] ?></div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <table class="table  align-middle"> <!-- table-bordered -->
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
                            if ($orderCountAll > 0) : ?>
                                <tr>
                                    <td class="activePic">
                                        <div class="ratio ratio-4x3">
                                            <img class=" object-fit-contain p-3" src="./image/<?= $row["mainimage"] ?>" alt="">
                                        </div>
                                    </td>
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
                                <td colspan="4 border-bottom-none"></td>
                                <td>訂單總額：</td>
                                <td><?= number_format($subtotal) ?></td>
                            </tr>
                        </tbody>
                    </table>


                    <div class="d-flex align-items-center justify-content-start pt-4">
                        <div class="col-3">
                            <p class=" d-inline h3 border-bottom border-dark mb-5">會員資料</p>
                            <h5 class="mt-3 fs-5 text-secondary">姓名：<?= $row["user_name"] ?></h5>
                            <h5 class="fs-5 text-secondary">Email：<?= $row["user_email"] ?></h5>
                            <h5 class="fs-5 text-secondary">手機：<?= $row["user_phone"] ?></h5>
                            <h5 class="fs-5 text-secondary">地址：<?= $row["user_address"] ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="../js/front.js"></script> -->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </header>


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
    </script>



</body>

</html>