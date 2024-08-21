<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";
    exit;
}

$id = $_GET["id"];

require_once("../db_connect.php");

$sql = "SELECT * FROM users 
WHERE id='$id' AND valid=1";

$result = $conn->query($sql);
$userCount = $result->num_rows;
$row = $result->fetch_assoc();

if ($userCount > 0) {
    $titile = $row["name"];

    $sqlFavorite = "SELECT user_like.*, product.name as product_name
    FROM user_like
    JOIN product ON user_like.product_id = product.id
    WHERE user_like.user_id = $id";

    $resultFavorite = $conn->query($sqlFavorite);
    $rowProducts = $resultFavorite->fetch_all(MYSQLI_ASSOC);
} else {
    $titile = "使用者不存在";
}

?>

<!doctype html>
<html lang="en">

<head>
    <title><?= $titile ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="users.php" title="回使用者列表"><i class="fa-solid fa-circle-left"></i></a>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <?php if ($userCount > 0) : ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>id</th>
                            <td><?= $row["id"] ?></td>
                        </tr>
                        <tr>
                            <th>Account</th>
                            <td><?= $row["account"] ?></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td><?= $row["name"] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $row["email"] ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= $row["phone"] ?></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td><?= $row["created_at"] ?></td>
                        </tr>
                    </table>
                    <div class="">
                        <a href="user-edit.php?id=<?= $row["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-user-pen"></i></a>
                    </div>
                    <h2 class="h3 mt-3">收藏商品</h2>
                    <?php if ($resultFavorite->num_rows > 0) : ?>
                        <ul>
                            <?php foreach ($rowProducts as $product) : ?>
                                <li><a href="/product/product.php?id=<?= $product["product_id"] ?>"><?= $product["product_name"] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        尚未收藏商品
                    <?php endif; ?>
                <?php else : ?>
                    使用者不存在
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>