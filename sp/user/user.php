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
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("css.php") ?>
    <style>
        body {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content ms-5 mt-3">
        <div class="row mb-2">
            <div class="d-flex justify-content-between align-items-start mt-3 mb-2">
                <p class="m-0 d-inline text-lg text-secondary h1">會員管理 /<span class="text-sm">會員資料</span></p>
                <div class="col-3 py-2 d-flex">
                    <a class="btn btn-dark " href="users.php" title="回到會員列表"><i class="fa-solid fa-left-long me-1"></i>回到會員列表</a>

                </div>
            </div>
        </div>
        <div class="container">

            <div class="row">
                <div class="col-5">
                    <img src="./upload/<?= $row["member_img"] ?>" alt="會員頭像" class="img-fluid">
                </div>
                <div class="col-6">
                    <?php if ($userCount > 0) : ?>
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <td><?= $row["id"] ?></td>
                            </tr>
                            <tr>
                                <th>帳號</th>
                                <td><?= $row["account"] ?></td>
                            </tr>
                            <tr>
                                <th>姓名</th>
                                <td>
                                    <?= $row["name"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>性別</th>
                                <td> <?= ($row["gender"] == 1) ? '男' : '女' ?></td>
                            </tr>
                            <tr>
                                <th>會員等級</th>
                                <td><?= $row["level_name"] ?></td>
                            </tr>
                            <tr>
                                <th>聯絡電話</th>
                                <td>
                                    <?= $row["phone"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>生日</th>
                                <td>
                                    <?= $row["birthday"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>信箱</th>
                                <td>
                                    <?= $row["email"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>地址</th>
                                <td>
                                    <?= $row["address"] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>註冊時間</th>
                                <td>
                                    <?= $row["created_at"] ?>
                                </td>
                            </tr>

                        </table>
                </div>
            </div>


            <div class="">
                <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-dark"><i class="fa-solid fa-user-pen me-1"></i>編輯</a>

            <?php else : ?>
                會員不存在
            <?php endif; ?>
            </div>
        </div>
        </div>

    </main>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>