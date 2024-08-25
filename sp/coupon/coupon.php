<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";
    exit;
}

$id = $_GET["id"];

require_once("../../db_connect.php");

$sql = "SELECT * FROM coupon_list
WHERE id='$id'";
$result = $conn->query($sql);
$couponCount = $result->num_rows;
$row = $result->fetch_assoc();

if ($couponCount > 0) {
    $titile = $row["name"];
} else {
    $titile = "優惠券不存在";
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>編輯優惠券</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <?php include("./css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content">
        <div class="container">
            <div class="mt-5 ">
                <div class="d-flex justify-content-between align-items-start">
                    <p class="m-0 d-inline  h2"><a href="coupon-list.php?p=1" class="btn btn-outline-danger">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a> 
                        #<?= $row["name"] ?></p>
                </div>
                <hr>
                <!-- table-->
                <div class="row mt-5  justify-content-center">
                    <div class="col-6 mt-5 pt-3">
                        <?php if ($couponCount > 0) : ?>
                            <form action="doUpdateCoupon.php" method="post">
                                <div>
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                </div>

                                <div class=" bg-body-tertiary border rounded text-center">
                                    <table class="align-middle col-12 my-2">
                                        <tr class="border-bottom">
                                            <th class="p-3 border-end">折扣代碼</th>
                                            <td class="px-5"> <?= $row["code"] ?></td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <th class="p-3 ps-4 border-end">消費金額</th>
                                            <td> <?= $row["minimum_amount"] ?></td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <th class="p-3 ps-4 border-end">折扣方式</th>
                                            <td class="px-5"> <?php if ($row["type_id"] == "1") {
                                                                    echo "百分比%";
                                                                } else {
                                                                    echo "金額";
                                                                }
                                                                ?></td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <th class="p-3 ps-4 border-end">折扣數</th>
                                            <td class="px-5 "><?= $row["discount_value"] ?></td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <th class="p-3 ps-4 border-end">可使用次數</th>
                                            <td class="px-5"><?= $row["maximum"] ?></td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <th class="p-3 ps-4 border-end">起始日期</th>
                                            <td class="px-5"><?= $row["start_date"] ?></td>
                                        </tr>
                                        <tr class="">
                                            <th class="p-3 ps-4 border-end">結束日期</th>
                                            <td class="px-5"> <?= $row["end_date"] ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="text-end ">


                                    <a href="coupon-edit.php?id=<?=$row["id"]?>" class="btn btn-dark p-2 me-2 mt-3">
                                        <i class="fa-regular fa-pen-to-square"></i> 編輯
                                    </a>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-danger p-2 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= urlencode($row["id"]) ?> ">
                                        <i class="fa-regular fa-trash-can"></i> 刪除
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hid den="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content ">
                                                <div class="modal-body">

                                                    <h1 class="modal-title py-3 text-center" id="exampleModalLabel">確定要刪除此筆資料
                                                        <i class="fa-solid fa-triangle-exclamation text-lg" style="color: #f50000;"></i>
                                                    </h1>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                    <button type="button" class="btn btn-dark" id="confirmDelete">確定</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        <?php else : ?>
                            優惠券不存在
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Quill-->
    <script src="../vendor/quill/quill.min.js"></script>
    <!-- Quill init-->
    <script src="../js/forms-texteditor.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
    <script>
        // 儲存刪除 URL 的變量
        let deleteUrl = '';

        // 當點擊觸發 Modal 的按鈕時，儲存刪除 URL
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                deleteUrl = 'doDeleteCoupon.php?id=' + encodeURIComponent(this.getAttribute('data-id'));
            });
        });

        // 當點擊“確定”按鈕時，執行刪除操作
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteUrl) {
                window.location.href = deleteUrl;
            }
        });
    </script>
</body>

</html>