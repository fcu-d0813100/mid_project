<?php
if (!isset($_GET["id"])) {
    echo "請輸入正確ID";
    exit;
}
$id = $_GET["id"];
require_once("../../db_connect.php");

$sql = "SELECT * FROM active WHERE id = '$id' AND  valid = 1";
$result = $conn->query($sql);
$activeCount = $result->num_rows;
$row = $result->fetch_assoc();

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
    <?php include("./css.php") ?>

</head>

<body>


    <header>
        <?php include("../../nav1.php") ?>


        <main class="main-content ">
            <div class="container">
                <div class="d-flex justify-content-between align-items-start pt-3 mt-5">
                    <p class="m-0 d-inline text-lg"><a href="active.php" class="text-dark text-decoration-none h2">活動列表 </a> <span class="text-sm fs-5"> / 活動編輯</span></p>
                </div>
                <hr>
                <!-- table-->
                <div class="py-3 d-flex justify-content-between gap-2">
                    <a href="active.php" class="btn btn-dark">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger"
                        onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteActive.php?id=<?= $row['id'] ?>'; }">
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
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <th>id</th>
                                    <td><?= $row["id"] ?></td>
                                </tr>
                                <tr>
                                    <th>品牌</th>
                                    <td>
                                        <label for="dropdown">修改活動品牌：</label>
                                        <select id="dropdown" name="brand">
                                            <!-- 之後關聯式資料表再改回數字 -->
                                            <option value="YSL">YSL</option>
                                            <option value="Bobbi Brown">Bobbi Brown</option>
                                            <option value="Estee Lauder">Estee Lauder</option>
                                            <option value="NARS">NARS</option>
                                            <option value="Lancome">Lancome</option>
                                        </select>
                                </tr>
                                <tr>
                                    <th>圖片</th>
                                    <td>
                                        <div class="mb-2">
                                            <label for="" class="mb-2">修改活動圖片: </label>
                                            <input type="file" name="image" id="" class="form-control">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動名稱</th>
                                    <td>
                                        <div class="mb-2">
                                            <label for="option1">修改活動名稱:</label>
                                            <input type="text" id="" class="form-control" name="name" value="<?= $row["name"] ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動日期</th>
                                    <td>
                                        <div class="mb-2">
                                            <label for="option1">修改活動日期時間:</label>
                                            <p class="mb-0 mt-2">開始:</p>
                                            <input type="datetime-local" id="" class="form-control" name="start_at" value="<?= $row["start_at"] ?>">
                                            <p class="mb-0 mt-2">結束:</p>
                                            <input type="datetime-local" id="" class="form-control" name="end_at" value="<?= $row["end_at"] ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動地點</th>
                                    <td>
                                        <div class="mb-2">
                                            <label for="option1">修改活動地點:</label>
                                            <input type="address" id="" class="form-control" name="address" value="<?= $row["address"] ?>">
                                        </div>
                                    </td>
                                </tr>
                                <!-- <tr>

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
                            </tr> -->



                                <tr>
                                    <th>活動報名人數</th>
                                    <td>
                                        <div class="mb-2">
                                            <label for="quantity">修改數量:</label>
                                            <input type="number" id="quantity" name="maxAPP" class="form-control" value="<?= $row["maxAPP"] ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>活動說明</th>
                                    <td>
                                        <div class="mb-2">
                                            <label for="option1">修改說明</label>
                                            <input type="text" id="" class="form-control" name="description" value="<?= $row["description"] ?>">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="text-end">
                                <button class="btn btn-dark" type="submit">修改</button>
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