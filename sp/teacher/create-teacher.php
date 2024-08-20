<?php require_once("../../db_connect.php"); ?>

<!doctype html>
<html lang="en">

<head>
    <title>Teachers</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>

    <main class="main-content px-3 pb-3 pt-5">
        <div class="container ">
            <div class="row d-flex justify-content-center align-items-center ">
                <div class="col-9">
                    <div>
                        <h1 class="h2 mt-5 pt-5 mb-2">新增教師</h1>
                        <div class="py-2">
                            <a class="btn btn-dark" href="teachers.php" title="回教師清單">
                                <i class="fa-solid fa-arrow-left-long py-1 pe-2"></i>回教師清單
                            </a>
                        </div>

                        <form action="doCreate-teacher.php" method="post" class="my-4">

                            <div class="mb-2">
                                <label class="form-label" for="account"><span class="text-danger">* </span> 請輸入帳號</label>
                                <input type="text" class="form-control" name="account" required>
                            </div>

                            <div class="mt-3 mb-2 d-flex row">
                                <div class="col">
                                    <label class="form-label" for="password"><span class="text-danger">* </span> 請輸入密碼</label>
                                    <input type="text" class="form-control" name="password" required>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="repassword"><span class="text-danger">* </span> 再次輸入密碼</label>
                                    <input type="text" class="form-control" name="repassword" required>
                                </div>

                            </div>

                            <div class=" mb-2 d-flex row mt-3">
                                <div class="col-4">
                                    <label class="form-label " for="name">姓名</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="col">
                                    <label class="form-label" for="nation">國籍</label>
                                    <input type="text" class="form-control" name="nation">
                                </div>
                                <div class="col-auto">
                                    <label class="form-label" for="gender">性別</label>
                                    <div class="pt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                            <label class="form-check-label" for="male">男</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                            <label class="form-check-label" for="female">女</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <label class="form-label" for="years">彩妝資歷 / 年</label>
                                    <input type="text" class="form-control" name="years" placeholder="請填入數字">
                                </div>
                            </div>

                            <div class="mt-3 mb-2">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>

                            <div class="text-center">
                                <button class="btn btn-dark px-5 my-3" type="submit">
                                    送出
                                </button>
                            </div>


                        </form>





                    </div>
                </div>
            </div>
    </main>
    <?php include("./js.php") ?>
</body>

</html>