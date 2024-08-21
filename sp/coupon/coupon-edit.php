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
    $titile = "使用者不存在";
}


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
    <!-- Quill CSS-->
    <link rel="stylesheet" href="../vendor/quill/quill.core.css">
    <link rel="stylesheet" href="../vendor/quill/quill.snow.css">
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content">
        <div class="d-flex justify-content-between align-items-start">
            <p class="m-0 d-inline text-lg text-secondary">優惠券管理 /<span class="text-sm">修改優惠券</span></p>
        </div>
        <hr>
        <!-- table-->

        <div class="py-2 d-flex justify-content-end gap-2">
            <a href="coupon-list.php" class="btn btn-outline-secondary btn-lg">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

        </div>

        <div class="row mt-3 justify-content-center">
            <div class="col-6">
                <?php if ($couponCount > 0) : ?>
                    <?php
                $start = isset($_GET["start"]) ? $_GET["start"] : $today;
                ?>
                    <form action="doUpdateCoupon.php" method="post">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">活動名稱</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">折扣代碼</label>
                            <input type="hidden" class="form-control" name="code" value="<?= $row["code"] ?>">
                            <div class="col-sm-7">
                                <?= $row["code"] ?>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">消費金額</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="minimum_amount" value="<?= $row["minimum_amount"] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">折扣方式</label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">金額</option>
                                    <option value="2">百分比%</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">折扣數</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="discount_value" value="<?= $row["discount_value"] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">可使用次數</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="maximum" value="<?= $row["maximum"] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">起始日期</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="start_date" value="<?= $row["start_date"] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">結束日期</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="end_date" value="<?= $row["end_date"] ?>">
                            </div>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                            <a href="doDeleteCoupon.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary ">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </div>
                    </form>

                <?php else : ?>
                    優惠券不存在
                <?php endif; ?>
            </div>

        </div>
    </main>
    <!-- Quill-->
    <script src="../vendor/quill/quill.min.js"></script>
    <!-- Quill init-->
    <script src="../js/forms-texteditor.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>