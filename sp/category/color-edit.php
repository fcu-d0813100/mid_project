<?php
require_once("../../db_connect.php");


if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";
    exit;
};


$id = $_GET["id"];

$sql = "SELECT color.id, color.product_id, color.color, color.stock, product_list.product_name
        FROM color 
        JOIN product_list ON color.product_id = product_list.id
        WHERE color.id = $id";

$result = $conn->query($sql);
if ($result->num_rows === 0) {
    die("找不到該商品");
}

$color = $result->fetch_assoc();



?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>品項管理</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <?php include("./css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content ">
        <div class="container ">
            <div class="py-3 mt-4">
                <p class="m-0 d-inline h2">編輯修改 <span class="text-sm fs-5"> / 色號及庫存</span></p>
            </div>
            <form class="mt-3" action="doUpdateColor.php" method="get">
                <input type="hidden" name="id" value="<?= $color['id'] ?>">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-2">商品編號：</th>
                            <td><?= $color['id'] ?></td>
                        </tr>
                        <tr>
                            <th>商品名稱：</th>
                            <td><?= $color['product_name'] ?></td>
                        </tr>
                        <tr>
                            <th>色號：</th>
                            <td> <input type="text" name="color" value="<?= $color['color'] ?>" class="form-control" min="0" required></td>
                        </tr>
                        <tr>
                            <th>庫存：</th>
                            <td>
                                <input type="number" name="stock" value="<?= $color['stock'] ?>" class="form-control" min="0" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-dark me-2">送出</button>
                <a class="btn btn-dark" href="color.php">返回</a>
            </form>
        </div>
    </main>
    <?php $conn->close(); ?>
    </div>


    <script>
        function sortTable(orderType) {
            var page = <?= $page ?>;
            var url = "article-list.php?p=" + page + "&order=" + orderType;
            window.location.href = url;
        }
    </script>


    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>