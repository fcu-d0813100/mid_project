<?php
if (!isset($_GET["id"])) {
    echo "請輸入正確ID";
    exit;
}
$id = $_GET["id"];
require_once("../../db_connect.php");

$sql = "SELECT * FROM active WHERE id = '$id' AND  valid = 1";
$result = $conn->query($sql);
$activeCount = $result->num_rows;
$row = $result->fetch_assoc();

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
    <?php include("./css.php") ?>
    <style>
        .main-content {
            padding-left: 200px;
            padding-right: 0;
        }
    </style>
</head>

<body>


    <header>
        <?php include("../../nav1.php") ?>

        <main class="main-content">
            <div class="container">
                <div class="d-flex justify-content-between align-items-start pt-3 mt-5">
                    <p class="m-0 d-inline text-lg text-dark"><a href="active.php" class="text-dark text-decoration-none h2">活動列表 </a> <span class="text-sm fs-5"> / 活動瀏覽</span></p>
                </div>
                <hr>
                <!-- table-->
                <div class="py-3 d-flex justify-content-between ">
                    <a href="active.php" class="btn btn-dark">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger"
                        onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteActive.php?id=<?= $row['id'] ?>'; }">
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </div>
                <div>
                </div>
                <div class="row">
                    <div class="col-lg">
                        <?php if ($activeCount > 0): ?>
                            <table class="table table-bordered">

                                <tr>
                                    <th>id</th>
                                    <td><?= $row["id"] ?></td>
                                </tr>
                                <tr>
                                    <th>圖片</th>
                                    <td>
                                        <div class="mb-2 ratio ratio-4x3 activePic">
                                            <img class="object-fit-cover " src="images/<?= $row["image"] ?>" alt="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動名稱</th>
                                    <td>
                                        <?= $row["name"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>報名人數/報名上限</th>
                                    <td>
                                        <?= $row["currentAPP"] ?>/<?= $row["maxAPP"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動開始日期時間</th>
                                    <td>
                                        <?= $row["start_at"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動結束日期時間</th>
                                    <td>
                                        <?= $row["end_at"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>地點</th>
                                    <td>
                                        <?= $row["address"] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動說明</th>
                                    <td>
                                        <?= $row["description"] ?>
                                    </td>
                                </tr>
                            </table>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </main>
        </div>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../js/front.js"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>