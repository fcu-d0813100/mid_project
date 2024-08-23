<?php
require_once("../../db_connect.php");



$search = isset($_GET['search']) ? $_GET['search'] : '';


if ($search) {
    $sql = "SELECT id, product_name FROM product_list WHERE product_name LIKE '%$search%' ORDER BY id";
} else {
    $sql = "SELECT id, product_name FROM product_list ORDER BY id";
}



$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

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
        <div class="container">
            <div class="py-3 mt-4">
                <p class="m-0 d-inline h2">新增<span class="text-sm fs-5"> / 色號及庫存</span></p>
            </div>

            <form action="create-color.php" method="get" class="mb-3">
                <div class="py-3">
                    <label for="">關鍵字 : </label>
                    <div class="input-group mt-2">
                        <input type="text" name="search" class="form-control" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋商品名稱">
                        <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i> 搜尋</button>
                        <?php if ($search): ?>
                            <a class="btn btn-primary" href="create-color.php">重新查詢</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <form action="DocreateColor.php" method="get">
                <div class="py-2"><label for="">選擇商品 :</label>
                    <select class="form-control mt-2" name="product_id" required>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>"><?= $product['product_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="py-2"><label for="">新增色號 :</label>
                    <input class="form-control mt-2" type="text" name="color">
                </div>
                <div class="py-2">
                    <label for="">新增庫存 :</label>
                    <input class="form-control mt-2" type="number" name="stock">
                </div>
                <button class="btn btn-dark mt-2 me-2" type="submit">新增</button>
                <a class="btn btn-dark mt-2" href="color.php">返回</a>
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