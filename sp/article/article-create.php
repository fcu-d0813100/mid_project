<?php
require_once("../../db_connect.php");
$sql = "SELECT 
    article.*,  
    brand.name AS brand_name,
    article_type.name AS type_name
FROM  article
JOIN brand ON article.brand_id = brand.id

JOIN  article_type ON article.type_id = article_type.id";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// 撈取 brand 資料
$sqlBrands = "SELECT id, name FROM brand";
$resultBrands = $conn->query($sqlBrands);
$brands = $resultBrands->fetch_all(MYSQLI_ASSOC);

// 撈取 type 資料
$sqlTypes = "SELECT id, name FROM article_type";
$resultTypes = $conn->query($sqlTypes);
$types = $resultTypes->fetch_all(MYSQLI_ASSOC);

// 使用 var_dump() 可以檢視資料結構
// var_dump($brands);
// var_dump($types);
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
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../css/style.default.premium.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../css/custom.css">
    <!-- font-awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Quill CSS-->
    <link rel="stylesheet" href="../vendor/quill/quill.core.css">
    <link rel="stylesheet" href="../vendor/quill/quill.snow.css">
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content container">
        <div class="d-flex justify-content-between align-items-start">
            <p class="m-0 d-inline text-lg text-secondary">文章列表 /<span class="text-sm">新增文章</span></p>
        </div>
        <hr>
        <!-- table-->
        <div class="py-2 d-flex justify-content-end gap-2">
            <a href="article-list.php" class="btn btn-outline-secondary btn-lg">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <a href="" class="btn btn-outline-secondary btn-lg">
                <i class="fa-regular fa-trash-can"></i>
            </a>
        </div>

        <div class="row mt-3 justify-content-start">
            <div class="col-lg">
                <table class="table table-bordered">
                    <form action="doCreateArticle.php" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered">
                            <!-- 品牌 -->
                            <tr class="form-label">
                                <th>品牌</th>
                                <td class="d-flex gap-3">
                                    <?php foreach ($brands as $brand) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="brand" id="<?= $brand["name"] ?>" value="<?= $brand["id"] ?>">
                                            <label class="form-check-label" for="<?= $brand["name"] ?>">
                                                <?= $brand["name"] ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <!-- 類型 -->
                            <tr class="form-label">
                                <th>類型</th>
                                <td class="d-flex gap-3">
                                    <?php foreach ($types as $type) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="<?= $type["name"] ?>" value="<?= $type["id"] ?>">
                                            <label class="form-check-label" for="<?= $type["name"] ?>">
                                                <?= $type["name"] ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>標題</th>
                                <td>
                                    <input class="form-control" type="text" name="title" required>
                                </td>
                            </tr>
                            <tr>
                                <th>內容</th>
                                <td class="">
                                    <textarea class="form-control" style="height: 500px;" type="text" name="content" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>圖片</th>
                                <td>
                                    <input class="form-control" type="file" name="main_pic">
                                </td>
                            </tr>
                            <tr>
                                <th>發布時間</th>
                                <td>
                                    <input class="form-control" type="date" name="date" required>
                                </td>
                            </tr>
                        </table>

                        <!-- 提交按鈕 -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-outline-secondary btn-lg">儲存</button>
                        </div>
                    </form>
                    <!-- 表單結束 -->
                </table>
            </div>
        </div>


    </main>

    <script script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>