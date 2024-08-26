<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>新增優惠券</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <!-- Quill CSS-->
    <link rel="stylesheet" href="../vendor/quill/quill.core.css">
    <link rel="stylesheet" href="../vendor/quill/quill.snow.css">

    <?php include("./css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content">



        <div class="container">
            <div class="mt-5 mx-5">
                <div class="d-flex justify-content-between align-items-start">

                    <p class="m-0 d-inline  h2">新增優惠券</p>

                </div>
                <hr>
                <!-- table-->
                <div class="py-2 d-flex justify-content-end gap-2">


                </div>

                <div class="row mt-5 justify-content-center">
                    <div class="col-10 text-end mt-5">
                        <form action="doCreateCoupon.php" method="post">
                            <div>
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            </div>
                            <div class="mb-3 row">

                                <label for="name" class="col-sm-2 col-form-label">活動名稱</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">折扣代碼</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-dark" onclick="generateCode()">隨機產生代碼</button>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">消費金額</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="minimum_amount" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">折扣方式</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="type_id">
                                        <option value="1">百分比%</option>
                                        <option value="2">金額</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">折扣數</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="discount_value" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">可使用次數</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="maximum" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">起始日期</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="start_date" id="start_date" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">結束日期</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="end_date" id="end_date" >
                                </div>
                            </div>
                            <a href="coupon-list.php?p=1" class="btn btn-dark px-3 me-3 mt-3" title="回優惠券列表">
                                <i class="fa-solid fa-arrow-left  me-2"></i> 取消
                            </a>
                            <button class="btn btn-dark px-3 mt-3" type="submit"><i class="fa-solid fa-file-import me-2"></i> 送出</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script>
        //  一鍵生成亂碼
        function generateCode() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const length = 8;
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                result += characters[randomIndex];
            }
            document.getElementById('code').value = result;
        }

        // 获取日期选择器
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        // 监听 start 日期的变化
        startDateInput.addEventListener('change', function() {
            const startDate = startDateInput.value;
            if (startDate) {
                // 设置 end 日期选择器的最小值为 start 日期
                endDateInput.min = startDate;
            }
        });

        // 初始设置 end 日期选择器的最小值为 start 日期
        endDateInput.min = startDateInput.value;
    </script>


    <!-- Quill-->
    <script src="../vendor/quill/quill.min.js"></script>
    <!-- Quill init-->
    <script src="../js/forms-texteditor.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>