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
            <p class="m-0 d-inline text-lg text-secondary">優惠券管理 /<span class="text-sm">修改優惠券</span></p>
        </div>
        <hr>
        <!-- table-->
        <div class="py-2 d-flex justify-content-end gap-2">
            <a href="coupon-list.php" class="btn btn-outline-secondary btn-lg">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <a href="" class="btn btn-outline-secondary btn-lg">
                <i class="fa-regular fa-trash-can"></i>
            </a>
        </div>

        <div class="row mt-3 justify-content-center">
            <div class="col-6">
                <form action="doUpdateCoupon.php" method="post">
                    
                <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">活動名稱</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">折扣代碼</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="">
                        </div>
                        <div class="col-sm-3">
                            <a href="" class="btn btn-outline-secondary">隨機產生代碼</a>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">消費金額</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">折扣方式</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example">
                                <option value="1">金額</option>
                                <option value="2">百分比%</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">可使用次數</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">起始日期</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">結束日期</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="">
                        </div>
                    </div>
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