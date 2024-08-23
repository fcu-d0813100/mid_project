<?php
require_once("../../db_connect.php");



$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    die("請帶入正確ID");
}


$sql = "SELECT sub_category.id, sub_category.name AS sub_name, sub_category.main_category_id, main_category.name AS main_name
        FROM sub_category
        JOIN main_category ON sub_category.main_category_id = main_category.id
        WHERE sub_category.id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("找不到該品項");
}

$category = $result->fetch_assoc();
$main_categories = $conn->query("SELECT id, name FROM main_category");


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>編輯品項</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <?php include("./css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content">
        <div class="container">
            <div class="py-3 mt-4">
                <p class="m-0 d-inline h2">編輯修改 /<span class="text-sm fs-5">品項管理</span></p>
            </div>
            <form action="doUpadateCategory.php" method="get">
                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                <div class="mt-2"><label class="bg-light py-2 fw-semibold" for="">編號<?= $category['id'] ?></label></div>
                <div class="form-group py-2">
                    <label for="sub_name">品項名稱</label>
                    <input type="text" class="form-control mt-2" id="sub_name" name="sub_name" value="<?= htmlspecialchars($category["sub_name"]) ?>" required>
                </div>
                <div class="form-group py-3">
                    <label for="main_category_id">部位分類</label>
                    <select class="form-control mt-2" id="main_category_id" name="main_category_id" required>
                        <?php while ($main_category = $main_categories->fetch_assoc()) : ?>
                            <option value="<?= $main_category['id'] ?>" <?= $main_category['id'] == $category['main_category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($main_category['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="py-3">
                    <button type="submit" class="btn btn-dark me-2">保存</button>
                    <a class="btn btn-dark" href="category.php">取消</a>
                </div>
            </form>
        </div>
        <?php $conn->close(); ?>
    </main>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>