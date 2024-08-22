<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";
    exit;
}

$id = $_GET["id"];

require_once("../../db_connect.php");

$sql = "SELECT users.* , user_level.name AS level_name FROM users
    JOIN user_level ON users.level_id = user_level.id
WHERE users.id = '$id' AND valid=1
";

$result = $conn->query($sql);
$userCount = $result->num_rows;
$row = $result->fetch_assoc();

if ($userCount > 0) {
    $title = $row["name"];
} else {
    $title = "使用者不存在";
}



?>
<!doctype html>
<html lang="en">

<head>
    <title>會員資料</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("css.php") ?>

    <style>
        body {
            background-color: #f5f5f5;
        }

        .img-size {
            height: 450px;
            width: auto;
        }
    </style>

</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content mt-3">
        <div class="container d-flex justify-content-center mt-4">
            <div class="col-10">
                <div class="row mb-2">
                    <div class="d-flex justify-content-between align-items-start mt-3 mb-2">
                        <p class="m-0 d-inline text-lg text-secondary h1">會員管理 <span class="fs-5"> / 會員資料</span></p>
                        <div class="py-2 ">
                            <a class="btn btn-dark " href="users.php" title="回到會員列表"><i class="fa-solid fa-left-long me-1"></i>回到會員列表</a>

                        </div>
                    </div>
                </div>

                <div class="rounded mt-4 d-flex justify-content-between align-items-center">
                    <div class="col-5">
                        <div class="ratio ratio-1x1">
                            <img src="./upload/<?= $row["member_img"] ?>" alt="會員頭像" class="rounded img-fluid shadow-sm img-size">
                        </div>
                    </div>
                    <div class="col-6 me-4">

                        <?php if ($userCount > 0) : ?>
                            <table class="table rounded align-middle table-light-subtle shadow-sm">
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">ID</th>
                                    <td class="ps-5"><?= $row["id"] ?></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">帳號</th>
                                    <td class="ps-5"><?= $row["account"] ?></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">姓名</th>
                                    <td class="ps-5">
                                        <?= $row["name"] ?>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">性別</th>
                                    <td class="ps-5"> <?= ($row["gender"] == 1) ? '男' : '女' ?></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">會員等級</th>
                                    <td class="ps-5"><?= $row["level_name"] ?></td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">聯絡電話</th>
                                    <td class="ps-5">
                                        <?= $row["phone"] ?>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">生日</th>
                                    <td class="ps-5">
                                        <?= $row["birthday"] ?>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">信箱</th>
                                    <td class="ps-5">
                                        <?= $row["email"] ?>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">地址</th>
                                    <td class="ps-5">
                                        <?= $row["address"] ?>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <th class="p-3 ps-4">註冊時間</th>
                                    <td class="ps-5">
                                        <?= $row["created_at"] ?>
                                    </td>
                                </tr>

                            </table>
                    </div>
                </div>


                <div class="mt-4 d-flex justify-content-end">
                    <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-dark"><i class="fa-solid fa-user-pen me-1"></i>編輯</a>

                <?php else : ?>
                    會員不存在
                <?php endif; ?>
                </div>
            </div>
        </div>
        </div>

    </main>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>