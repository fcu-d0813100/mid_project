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


/*if ($userCount > 0) {
    $title = $row["name"];

    $sqlFavotire = "SELECT user_like.*, product.name AS product_name, product.id AS product_id
    FROM  user_like
    JOIN  product ON user_like.product_id=product.id
    WHERE user_like.user_id=$id
    ";

    $resultFavotire = $conn->query($sqlFavotire);
    $rowProducts = $resultFavotire->fetch_all(MYSQLI_ASSOC);
} else {
    $title = "使用者不存在";
}*/


?>
<!doctype html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="users.php" title="回到會員列表"><i class="fa-solid fa-left-long"></i></a>
        </div>
        <div class="row ">
            <div class="col-lg-4">
                <?php if ($userCount > 0) : ?>
                    <table class="table table-bordered">
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
                    <h2>會員照片</h2>
                    <img src="./upload/<?= $row["member_img"] ?>" alt="" class="img-fluid">
                    <div class="">
                        <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-user-pen"></i></a>
                    </div>

                    <!-- <h2 class="h3 mt-3">收藏商品</h2> -->
                    <!-- <?php if ($resultFavotire->num_rows > 0) : ?> 
                        <ul>
                            <?php foreach ($rowProducts as $product) : ?>
                                <li><a href="/product/product.php?id=<?= $product["product_id"] ?>"></a><?= $product["product_name"] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        尚未收藏商品
                    <?php endif; ?> -->
                <?php else : ?>
                    使用者不存在
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>