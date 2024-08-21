<?php
require_once("../../db_connect.php");

?>


<!doctype html>
<html lang="en">

<head>
    <title>Create User</title>
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
    </style>
</head>

<body>
    <div class="container">
        <div class="py-2">
            <h1 class="text-center">新增會員資料</h1>
        </div>
        <div class="d-flex">
            <div class="col-lg-5 me-5">
                <!-- 圖片 -->

                <form action="doCreateUser.php" method="post" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="">
                            <h2>會員頭像</h2>
                        </label>
                        <!-- <div class="row g-3 mt-3 row-cols-xl-6 row-cols-lg-4 row-cols-md-3 row-cols-2"> -->
                        <div class="col">
                            <div class="ratio ratio-1x1">
                                <!-- 預設顯示的頭像 -->
                                <img id="avatarPreview" class="object-fit-cover avatar-preview" src="./upload/avatar01.jpg" alt="會員頭像">
                            </div>
                        </div>
                        <!-- </div> -->
                    </div>

                    <!-- 上傳區塊 -->
                    <div class="mb-2">
                        <label for="">上傳會員照片</label>
                        <input type="file" id="avatarUpload" name="meupload" class="form-control" onchange="previewAvatar()">
                        <button type="button" class="btn btn-secondary mt-2" onclick="resetAvatar()">取消上傳</button>
                        <!-- <input type="file" id="avatarUpload" name="meupload" class="form-control" required onchange="previewAvatar()"> -->
                        <!-- <button type="submit" class="btn btn-primary mt-2">上傳頭像</button> -->
                    </div>
            </div>

            <div class="col-lg-5 ms-5">

                <div class="mb-2">
                    <label class="form-label" for="name"><span class="text-danger">*</span>帳號</label>
                    <input type="text" class="form-control" name="account" required>
                </div>
                <div class="mb-2">
                    <label class="form-label" for="name"><span class="text-danger">*</span>密碼</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-2">
                    <label class="form-label" for="name"><span class="text-danger">*</span>確認密碼</label>
                    <input type="password" class="form-control" name="repassword" placeholder="請再次輸入密碼" required>
                </div>

                <!--  -->
                <div class="mb-2">
                    <label class="form-label" for="name"><span class="text-danger">*</span>姓名</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="mb-2">
                    <label class="form-label" for="name">性別</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="1" checked>
                        <label class="form-check-label" for="inlineRadio1">男</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">女</label>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label" for="phone">連絡電話</label>
                    <input type="tel" class="form-control" name="phone">
                </div>
                <div class="mb-2">
                    <label class="form-label" for="birthday">生日</label>
                    <input type="date" class="form-control" name="birthday">
                </div>
                <div class="mb-2">
                    <label class="form-label" for="email">信箱</label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div class="mb-2">
                    <label class="form-label" for="city">地址</label>
                    <div class="">
                        <select class="form-select " aria-label="Default select example" name="city">
                            <option value="">請選擇縣市</option>
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
                        <input type="text" class="form-control mt-2" name="streetAddress">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label" for="level_id">會員等級</label>
                    <select class="form-control" name="level_id">
                        <option value="1">一般會員</option>
                        <option value="2">VIP</option>
                        <!-- <option value="3">取消管理員</option> -->
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a class="btn btn-primary align-self-center me-md-2" href="users.php" title="回會員管理列表">返回</a>
                    <button type="submit" class="btn btn-primary">送出</button>
                </div>
            </div>
        </div>
        </form>

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


</html>