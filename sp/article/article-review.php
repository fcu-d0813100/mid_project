<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入get id 變數";
    exit;
}


$id = $_GET["id"];

require_once("../../db_connect.php");

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
            <p class="m-0 d-inline text-lg text-secondary">文章列表 /<span class="text-sm">檢視文章</span></p>
        </div>
        <hr>
        <!-- table-->
        <div class="py-2 d-flex justify-content-end gap-2">
            <a href="article-list.php" class="btn btn-outline-secondary btn-lg">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <a href="article-edit.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary btn-lg">
                <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-outline-secondary btn-lg"
                onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteArticle.php?id=<?= $row['id'] ?>'; }">
                <i class="fa-regular fa-trash-can"></i>
            </a>
        </div>

        <div class="row mt-3">
            <div class="col-lg">

                <?php if ($articleCount > 0) : ?>
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-2">編號</th>
                            <td><?= $row["id"] ?></td>
                        </tr>
                        <tr>
                            <th>品牌</th>
                            <td><?= $row["brand_name"] ?></td>
                        </tr>
                        <tr>
                            <th>類型</th>
                            <td><?= $row["type_name"] ?></td>
                        </tr>
                        <tr>
                            <th>標題</th>
                            <td><?= $row["title"] ?></td>
                        </tr>

                        <tr>
                            <th>內容</th>
                            <td><?= $row["content"] ?></td>
                        </tr>
                        <tr>
                            <th>圖片</th>
                            <td class="ratio ratio-4x3"><img class="object-fit-cover p-3" src="./pic/<?= $row["main_pic"] ?>" alt=""></td>
                        </tr>
                        <tr>
                            <th>發布時間</th>
                            <td><?= $row["launched_date"] ?></td>
                        </tr>
                    </table>
                <?php else: ?>
                    文章不存在
                <?php endif; ?>
            </div>

        </div>
    </main>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>