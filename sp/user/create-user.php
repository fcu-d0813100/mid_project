<?php
require_once("../../db_connect.php");

?>
<!doctype html>
<html lang="en">

<head>
    <title>註冊會員</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("css.php") ?>
    <?php include("js.php") ?>
    <style>
        /* 圓形頭像 */
        .avatar-preview {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .form-control {
            border-radius: 8px;
            box-shadow: 5px #e9ecef;
        }

        .form-select {
            border-radius: 8px;
            box-shadow: 5px #e9ecef;
        }

        .text-style {
            font-size: 16px;
            font-weight: 500;
            color: #111111;
        }

        .btn {
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container pt-5 mt-5">
        <div>
            <h1 class="text-center fw-bold py-3">會員註冊</h1>
            <hr>
            <form action="doCreateUser.php" method="post" enctype="multipart/form-data">
                <div class="d-flex mt-4">

                    <div class="col-lg-10 me-5">

                        <div class="mb-3 row">
                            <div class="col">
                                <label class="form-label text-style" for="account"><span class="text-danger">* </span>帳號</label>
                                <input type="text" class="form-control" name="account" placeholder="請輸入英文及數字" required>
                            </div>
                        </div>
                        <div class=" mb-3 d-flex row">

                            <div class="col">
                                <label class="form-label text-style" for="password"><span class="text-danger">* </span> 密碼</label>
                                <input type="password" class="form-control" name="password" placeholder="請輸入密碼" required>
                            </div>
                            <div class="col">
                                <label class="form-label text-style" for="repassword"><span class="text-danger">* </span> 確認密碼</label>
                                <input type="password" class="form-control" name="repassword" placeholder="請再次輸入密碼" required>
                            </div>

                        </div>

                        <!--  -->
                        <div class="mb-3 d-flex row">
                            <div class="col-5">
                                <label class="form-label text-style" for="name"><span class="text-danger">*</span>姓名</label>
                                <input type="text" class="form-control" name="name" placeholder="請輸入真實姓名" required>
                            </div>
                            <div class="col-auto">
                                <label class="form-label text-style" for="gender">性別</label>
                                <div class="pt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="1" checked>
                                        <label class="form-check-label text-style" for="inlineRadio1">男</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2">
                                        <label class="form-check-label text-style" for="inlineRadio2">女</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <label class="form-label text-style" for="birthday">生日</label>
                                <input type="date" class="form-control" name="birthday">
                            </div>

                        </div>
                        <div class="mb-3 d-flex row">
                            <div class="col-3">
                                <label class="form-label text-style" for="phone"> <span class="text-danger">*</span>連絡電話</label>
                                <input type="tel" class="form-control text-style" pattern="\d{10}"
                                    name="phone" placeholder="請輸入連絡電話" required>
                                <!-- 正規表達式讓他十碼 -->
                            </div>
                            <div class="col">
                                <label class="form-label text-style" for="email"> <span class="text-danger">*</span>信箱</label>
                                <input type="email" class="form-control" name="email" placeholder="請輸入信箱" required>
                            </div>

                            <!-- <div class="col-3">
                            <label class="form-label text-style" for="level_id">會員等級</label>
                            <select class="form-select text-style" aria-label="Default select example" name="level_id">
                                <option value="1">一般會員</option>
                                <option value="2">白金會員</option>
                                <option value="3">鑽石會員</option>
                            </select>
                        </div> -->
                        </div>

                        <div class="mb-3 d-flex row">
                            <label class="form-label text-style" for="city">地址</label>
                            <div class="col-3">
                                <select class="form-select text-style" aria-label="Default select example" name="city">
                                    <option value="" disabled selected>請選擇縣市</option>
                                    <option value="臺北市">臺北市</option>
                                    <option value="新北市">新北市</option>
                                    <option value="基隆市">基隆市</option>
                                    <option value="桃園市">桃園市</option>
                                    <option value="新竹市">新竹市</option>
                                    <option value="新竹縣">新竹縣</option>
                                    <option value="苗栗縣">苗栗縣</option>
                                    <option value="臺中市">臺中市</option>
                                    <option value="彰化縣">彰化縣</option>
                                    <option value="南投縣">南投縣</option>
                                    <option value="嘉義市">嘉義市</option>
                                    <option value="嘉義縣">嘉義縣</option>
                                    <option value="臺南市">臺南市</option>
                                    <option value="高雄市">高雄市</option>
                                    <option value="屏東縣">屏東縣</option>
                                    <option value="宜蘭縣">宜蘭縣</option>
                                    <option value="花蓮縣">花蓮縣</option>
                                    <option value="臺東縣">臺東縣</option>
                                    <option value="澎湖縣">澎湖縣</option>
                                    <option value="金門縣">金門縣</option>
                                    <option value="連江縣">連江縣</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="streetAddress" placeholder="請輸入完整地址">
                            </div>
                        </div>

                        <div class="row mb-3 d-flex align-items-center">
                            <label for="form-label text-style">上傳頭像</label>
                            <div class="col">
                                <!-- 上傳區塊 -->

                                <div class="d-flex">
                                    <div class="">
                                        <input type="file" id="avatarUpload" name="meupload" class="form-control mt-2" onchange="previewAvatar()">
                                    </div>
                                    <div class="">
                                        <button type="button" class="btn btn-outline-danger mt-2 ms-3" onclick="resetAvatar()"><i class="fa-solid fa-rotate-left"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div class=" d-flex justify-content-end ">
                                    <div class="d-grid col-3">
                                        <button type="submit" class="btn btn-dark py-2 fw-bold fs-5">
                                            註冊
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-2 me-3">
                        <!-- 圖片 -->


                        <div class="mb-2">

                            <!-- <div class="row g-3 mt-3 row-cols-xl-6 row-cols-lg-4 row-cols-md-3 row-cols-2"> -->
                            <div class="col">
                                <div class="ratio ratio-1x1 mb-3 w-75">
                                    <!-- 預設顯示的頭像 -->
                                    <img id="avatarPreview" class="object-fit-cover avatar-preview mt-4" src="./upload/avatar01.jpg" alt="會員頭像">
                                    <div class="mt-5 pt-5">
                                        <p class="text-center text-lg text-secondary mt-5 pt-5">頭像預覽</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</body>
<script>
    function previewAvatar() {
        let file = document.getElementById('avatarUpload').files[0];
        let preview = document.getElementById('avatarPreview');

        const reader = new FileReader();
        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "./upload/avatar01.jpg"; // 如果沒有選擇新圖片，保留預設圖片
        }
    }

    function resetAvatar() {
        document.getElementById('avatarUpload').value = ""; // 清空檔案
        document.getElementById('avatarPreview').src = "./upload/avatar01.jpg"; // 重置頭像預覽
    }
</script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../js/front.js"></script>


</html>