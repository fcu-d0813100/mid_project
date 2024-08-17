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
</head>

<body>


    <header class="py-4">
        <?php include("../../nav1.php") ?>

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-start">
                <p class="m-0 d-inline text-lg text-secondary">活動列表 /<span class="text-sm">活動編輯</span></p>
            </div>
            <hr>
            <!-- table-->
            <div class="py-2 d-flex justify-content-between gap-2">
                <a href="active.php" class="btn btn-outline-secondary btn-lg">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <a href="doDeleteActive.php" class="btn btn-outline-secondary btn-lg">
                    <i class="fa-regular fa-trash-can"></i>
                </a>
            </div>
            <div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <form action="doUpdateActive.php" method="post">
                        <table class="table table-bordered">
                            <tr>
                                <th>id</th>
                                <td>12</td>
                            </tr>
                            <tr>
                                <th>圖片</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="" class="mb-2">修改活動圖片: </label>
                                        <input type="file" name="pic" id="" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>活動名稱</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="option1">修改活動名稱:</label>
                                        <input type="text" id="" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>活動日期</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="option1">修改活動日期:</label>
                                        <input type="date" id="" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>活動地點</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="option1">修改活動地點:</label>
                                        <input type="address" id="" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>活動狀態</th>
                                <td>
                                    <form>
                                        <label for="option1">報名中</label>
                                        <input type="radio" id="option1" name="choices" value="1">

                                        <label for="option2">已截止</label>
                                        <input type="radio" id="option2" name="choices" value="2">

                                        <label for="option3">進行中</label>
                                        <input type="radio" id="option3" name="choices" value="3">
                                        <label for="option3">已結束</label>
                                        <input type="radio" id="option3" name="choices" value="4">
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th>活動報名人數</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="quantity">修改數量:</label>
                                        <input type="number" id="quantity" name="quantity" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>活動說明</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="option1">修改說明</label>
                                        <input type="text" id="" class="form-control">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="text-end">
                            <a href="doUpdateActive.php" class="btn btn-outline-secondary btn-lg">修改</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        </div>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../js/front.js"></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>

</html>