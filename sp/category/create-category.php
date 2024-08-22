<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>新增品項</title>
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
            <div class="py-3">
                <p class="m-0 d-inline text-lg text-secondary">新增品項 /<span class="text-sm">品項管理</span></p>
            </div>

            <form action="doCreateCategory.php" method="get">
                <div class="mb-2">
                    <label class="form-label" for="name"><span class="text-danger">*</span>品項名稱</label>
                    <input type="text" class="form-control" name="category" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="name"><span class="text-danger">*</span>部位分類</label>
                    <select class="form-select" name="main_category_id" id="">
                        <option value="1">面部彩妝</option>
                        <option value="2">雙頰彩妝</option>
                        <option value="3">眼部彩妝</option>
                        <option value="4">唇部彩妝</option>
                    </select>
                </div>
                <div class="py-2">
                    <button class="btn btn-primary " type="submit">送出</button>
                    <a class="btn btn-secondary" href="category.php" title="回管理列表">返回</a>
                </div>

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