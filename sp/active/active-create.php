<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bootstrap Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <?php include("./css.php") ?>
    <style>
        .main-content {
            padding-left: 200px;
            padding-right: 0;
        }
    </style>
</head>

<body>


    <header class="py-4">
        <?php include("../../nav1.php") ?>

        <main class="main-content container">
            <div class="d-flex justify-content-between align-items-start">
                <p class="m-0 d-inline text-lg"><a href="active.php" class="text-dark text-decoration-none h2">活動列表 </a><span class="text-sm fs-5"> / 活動編輯</span></p>
            </div>
            <hr>
            <!-- table-->
            <div class="py-3 d-flex justify-content-between gap-2">
                <a href="active.php" class="btn btn-dark">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <a href="" class="btn btn-outline-danger">
                    <i class="fa-regular fa-trash-can"></i>
                </a>
            </div>
            <div class="row">
                <div class="col-lg">
                    <form action="doCreateActive.php" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered">
                            <tr>
                                <th>活動名稱</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="" class="mb-2">輸入活動名稱: </label>
                                        <input type="text" id="" class="form-control" name="name">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>活動品牌</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="dropdown">選擇一個品牌：</label>
                                        <select id="dropdown" name="brand">
                                            <!-- 之後關聯式資料表再改回數字 -->
                                            <option value="YSL">YSL</option>
                                            <option value="Bobbi Brown">Bobbi Brown</option>
                                            <option value="Estee Lauder">Estee Lauder</option>
                                            <option value="NARS">NARS</option>
                                            <option value="Lancome">Lancome</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>圖片</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="" class="mb-2">選取活動圖片: </label>
                                        <input type="file" name="image" id="" class="form-control">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>活動日期</th>
                                <td>
                                    <div class="mb-2">
                                        <input type="datetime-local" id="" class="form-control mb-2" name="start_at">
                                        <input type="datetime-local" id="" class="form-control" name="end_at">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>地點</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="" class="mb-2">輸入活動地點: </label>
                                        <input type="address" id="" class="form-control" name="address">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>報名人數</th>
                                <td>
                                    <div class="row">

                                        <div class="col-6">

                                            <label for="" class="mb-2">報名最大人數 :</label>
                                            <div class="">
                                                <input type="number" id="" class="form-control" name="maxAPP">
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <th>活動說明</th>
                                <td>
                                    <div class="mb-2">
                                        <label for="" class="mb-2">輸入活動內容: </label>
                                        <input type="text" id="" class="form-control" name="description">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="text-end">
                            <button class="btn btn-dark" type="submit">新增</button>
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