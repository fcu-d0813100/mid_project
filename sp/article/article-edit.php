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
    <main class="main-content">
        <div class="d-flex justify-content-between align-items-start">
            <p class="m-0 d-inline text-lg text-secondary">文章列表 /<span class="text-sm">文章編輯</span></p>
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

        <div class="row mt-3">
            <div class="col-lg">
                <form action="doUpdateArticle.php" method="post">
                    <table class="table table-bordered">
                        <tr>
                            <th>編號</th>
                            <td><input type="text" name="id"></td>
                        </tr>
                        <tr>
                            <th>標籤</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>標題</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>內容</th>
                            <td>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-10">
                                            <div class="editor">
                                                <div id="editor"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>圖片</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>發布時間</th>
                            <td></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="text-end">
                <a href="doUpdateArticle.php" class="btn btn-outline-secondary btn-lg ">儲存</a>
            </div>
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