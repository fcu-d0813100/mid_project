<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入get id 變數";
    exit;
}


$id = $_GET["id"];

require_once("/xampp/htdocs/mid_project/db_connect.php");

$sql = "SELECT 
    article.*,  
    brand.name AS brand_name,
    article_type.name AS type_name
FROM  article
JOIN brand ON article.brand_id = brand.id

JOIN  article_type ON article.type_id = article_type.id
WHERE article.id='$id' 
";  //有用join 記得指定資料表



$result = $conn->query($sql);
$articleCount = $result->num_rows;
$row = $result->fetch_assoc();

if ($articleCount > 0) {
    $title = $row["title"];
} else {
    $title = "使用者不存在";
}
// 撈取 brand 資料
$sqlBrands = "SELECT id, name FROM brand";
$resultBrands = $conn->query($sqlBrands);
$brands = $resultBrands->fetch_all(MYSQLI_ASSOC);

// 撈取 type 資料
$sqlTypes = "SELECT id, name FROM article_type";
$resultTypes = $conn->query($sqlTypes);
$types = $resultTypes->fetch_all(MYSQLI_ASSOC);

// var_dump($rows);
$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
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
            <p class="m-0 d-inline text-lg text-secondary">文章列表 /<span class="text-sm">編輯文章</span></p>
        </div>
        <hr>
        <!-- table-->
        <div class="py-2 d-flex justify-content-end gap-2">
            <a href="article-list.php" class="btn btn-outline-secondary btn-lg">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-outline-secondary btn-lg"
                onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteArticle.php?id=<?= $row['id'] ?>'; }">
                <i class="fa-regular fa-trash-can"></i>
            </a>
        </div>

        <div class="row mt-3">
            <div class="col-lg">
                <form action="doUpdateArticle.php" method="post" enctype="multipart/form-data">
                    <?php if ($articleCount > 0) : ?>
                        <table class="table table-bordered">
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <tr>
                                <th class="col-1">編號</th>
                                <td><?= $row["id"] ?></td>
                            </tr>
                            <!-- 品牌 -->
                            <tr class="form-label">
                                <th>品牌</th>
                                <td class="d-flex gap-3">
                                    <?php
                                    $selected_brand_id = $row["brand_id"];
                                    foreach ($brands as $brand) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="brand" id="<?= $brand["name"] ?>" value="<?= $brand["id"] ?>" <?php if ($brand["id"] == $selected_brand_id) echo 'checked'; ?>>
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
                                    <?php $selected_type_id = $row["type_id"];
                                    foreach ($types as $type) : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="<?= $type["name"] ?>" value="<?= $type["id"] ?>" <?php if ($type["id"] == $selected_type_id) echo 'checked'; ?>>
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
                                    <input type="text" class="form-control" name="title"
                                        value="<?= $row["title"] ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>內容</th>
                                <td>
                                    <textarea style="height: 500px;" type="text" class="form-control" name="content"><?= $row["content"] ?></textarea>
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
                                <td><input type="date" class="form-control" name="date"
                                        value="<?= $row["launched_date"] ?>"></td>
                            </tr>
                        </table>
                    <?php else: ?>
                        文章不存在
                    <?php endif; ?>

            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-outline-secondary btn-lg">儲存</button>
            </div>
            </form>
        </div>
    </main>
    <!-- Quill-->
    <script src="../vendor/quill/quill.min.js"></script>
    <!-- Quill init-->
    <script src="../js/forms-texteditor.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>