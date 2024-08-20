<?php
require_once("./productdb_connect.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("无效的 ID");
}

// 获取当前颜色信息
$sql = "SELECT color.id, product.product_name, color.color, color.stock, color.product_id
        FROM color
        JOIN product ON color.product_id = product.id
        WHERE color.id = $id";

$result = $conn->query($sql);

if ($result) {
    $color = $result->fetch_assoc();
} else {
    die("Error: " . $conn->error);
}

// 获取所有唯一的产品列表
$searchKeyword = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT id, product_name FROM product WHERE product_name LIKE '%$searchKeyword%' ORDER BY product_name";
$result = $conn->query($sql);

// 处理重复的产品名称
$uniqueProducts = [];
while ($row = $result->fetch_assoc()) {
    $productName = htmlspecialchars($row['product_name']);
    if (!isset($uniqueProducts[$productName])) {
        $uniqueProducts[$productName] = $row['id'];
    }
}

// 处理 POST 请求
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $color_name = $conn->real_escape_string($_POST['color']);
    $stock = (int)$_POST['stock'];
    $product_id = (int)$_POST['product_id'];

    if ($color_name && $stock >= 0 && $product_id > 0) {
        $update_sql = "UPDATE color SET color = '$color_name', stock = $stock, product_id = $product_id WHERE id = $id";
        if ($conn->query($update_sql)) {
            header("Location: color.php");
            exit();
        } else {
            die("Error: " . $conn->error);
        }
    } else {
        $error_message = "所有字段都必须填写且库存量必须是非负整数";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>色號庫存</title>
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
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content ">
        <div class="container">
            <h3>編輯</h3>
            <form action="" method="post">
                <?php if (isset($error_message)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">

                    <p class="form-control-plaintext">色號編號：<?= htmlspecialchars($color['id']) ?></p>
                </div>
                <div class="mb-3">
                    <label for="product_id" class="form-label">產品名稱</label>
                    <select id="product_id" name="product_id" class="form-select" required>
                        <?php foreach ($uniqueProducts as $productName => $productId) : ?>
                            <option value="<?= $productId ?>" <?= ($productId == $color['product_id']) ? 'selected' : '' ?>>
                                <?= $productName ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">色號</label>
                    <input type="text" id="color" name="color" class="form-control" value="<?= htmlspecialchars($color['color']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">庫存量</label>
                    <input type="number" id="stock" name="stock" class="form-control" value="<?= htmlspecialchars($color['stock']) ?>" required min="0">
                </div>
                <button type="submit" class="btn btn-primary">保存</button>
                <a class="btn btn-secondary" href="color.php">取消</a>
            </form>
        </div>
    </main>


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
<?php $conn->close(); ?>