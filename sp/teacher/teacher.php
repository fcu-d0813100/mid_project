<?php

if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";
    exit;
}
$id = $_GET["id"];

require_once("../../db_connect.php");

$sql = "SELECT * FROM teachers WHERE id ='$id' AND valid=1 ";

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
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>

    <main class="main-content px-3 pb-3 pt-5">
        <div class="container ">
            <div class="mt-4 row d-flex justify-content-center align-items-center ">
                <div class="col-10">

                    <h1 class="h2 mt-5 pt-5 mb-2">教師資訊</h1>
                    <div class="py-2 ">
                        <a class="btn btn-dark" href="teachers.php" title="回教師清單">
                            <i class="fa-solid fa-arrow-left-long py-1 pe-2"></i>回教師清單
                        </a>

                    </div>

                    <div class="bg-light-subtle bg-opacity-75 shadow-sm rounded mt-3 pe-5 d-flex justify-content-between align-items-center">
                        <?php if ($userCount > 0) : ?>
                            <div class="col-5">
                                <div class="ratio ratio-1x1 ">
                                    <img class="rounded" src="../../images/teacher/T_1.jpg" alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <table class="align-middle w-100">
                                    <tr class="border-bottom">
                                        <th class="p-3 ps-4">帳號</th>
                                        <td class="ps-5"><?= $row["account"] ?></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-3 ps-4">姓名</th>
                                        <td class="ps-5"><?= $row["name"] ?></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-3 ps-4">Email</th>
                                        <td class="ps-5"><?= $row["email"] ?></td>
                                    </tr>

                                    <?php if ($row["gender"] == "male") {
                                        $row["gender"] = "男";
                                    } else {
                                        $row["gender"] = "女";
                                    }
                                    ?>
                                    <tr class="border-bottom">
                                        <th class="p-3 ps-4">性別</th>
                                        <td class="ps-5"><?= $row["gender"] ?></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-3 ps-4">國籍</th>
                                        <td class="ps-5"><?= $row["nation"] ?></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-3 ps-4">資歷
                                        </th>
                                        <td class="ps-5"><?= $row["years"] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="p-3 ps-4">註冊日期</th>
                                        <td class="ps-5"><?= $row["created_at"] ?></td>
                                    </tr>
                                </table>
                            </div>
                        <?php else: ?>
                            使用者不存在
                        <?php endif; ?>
                    </div>
                    <?php if ($userCount > 0) : ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-body-secondary  m-0 fs-5">ID number - <?= $row["id"] ?></p>
                            <a href="teacher-edit.php?id=<?= $row["id"] ?>" class="btn btn-dark mt-4">
                                <i class="py-1 me-2 fa-solid fa-pen-to-square"></i>編輯
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
    </main>
    <?php include("./js.php") ?>

</body>

</html>