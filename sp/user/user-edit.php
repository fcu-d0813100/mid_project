<?php
if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";
    exit;
}

$id = $_GET["id"];

require_once("../../db_connect.php");

$sql = "SELECT users.* , user_level.name AS level_name FROM users
    JOIN user_level ON users.level_id = user_level.id
    WHERE users.id = '$id' AND valid=1
";

$result = $conn->query($sql);
$userCount = $result->num_rows;
$row = $result->fetch_assoc();

if ($userCount > 0) {
    $title = $row["name"];
} else {
    $title = "使用者不存在";
}


?>
<!doctype html>
<html lang="en">

<head>
    <title>編輯會員資料</title>
    <!-- <title><?= $title ?></title> -->
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("css.php") ?>
    <script>
        function confirmDelete(id) {
            let confirmation = confirm("您確定要刪除這筆資料嗎?");
            if (confirmation) {
                // 使用者確認刪除，重定向到刪除頁面
                window.location.href = 'doDeleteUser.php?id=' + id;
            }
            // 使用者取消刪除，返回 false 防止跳轉
            return false;
        }
    </script>
    <style>
        body {
            background-color: #f5f5f5;
        }

        .img-size {
            max-height: 450px;
            width: auto;
        }
    </style>

</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content mt-3">
        <div class="container  d-flex justify-content-center mt-4">
            <div class="col-10">
                <div class="row mb-2">
                    <div class="d-flex justify-content-between align-items-start mt-3 mb-2">
                        <p class="m-0 d-inline text-lg text-secondary h1">會員管理 <span class="fs-5"> / 會員編輯</span></p>

                        <div class="py-2">
                            <a class="btn btn-dark" href="user.php?id=<?= $row["id"] ?>" title="回到會員資料"><i class="fa-solid fa-left-long me-1"></i>回到上一頁</a>
                        </div>
                    </div>
                </div>
                <form action="doUpdateUser.php" method="post" enctype="multipart/form-data">
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div class="col-5 ">
                            <div class="ratio ratio-1x1 ">
                                <img src="./upload/<?= $row["member_img"] ?>" alt="會員頭像" class="rounded img-size shadow-sm" id="avatarPreview">
                            </div>
                        </div>
                        <div class="col-6 me-4">
                            <?php if ($userCount > 0) : ?>
                                <table class="table rounded align-middle card-color shadow-sm">
                                    <input type="hidden" name="id"
                                        value="<?= $row["id"] ?>">
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">ID</th>
                                        <td class="ps-5"><?= $row["id"] ?></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">帳號</th>
                                        <td class="ps-5"><?= $row["account"] ?></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">姓名</th>
                                        <td class="ps-5">
                                            <input type="text" class="form-control"
                                                name="name"
                                                value="<?= $row["name"] ?>">
                                        </td>
                                    </tr>

                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">性別</th>
                                        <td class="ps-5">
                                            <div>
                                                <input type="radio" id="male" name="gender" value="1" <?= ($row["gender"] == 1) ? 'checked' : '' ?>>
                                                <label for="male">男</label>
                                                <input type="radio" id="female" name="gender" value="2" <?= ($row["gender"] == 2) ? 'checked' : '' ?>>
                                                <label for="female">女</label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">會員等級</th>
                                        <td class="ps-5">
                                            <select class="form-control" name="level_id">
                                                <option value="1" <?= ($row["level_id"] == 1) ? 'selected' : '' ?>>一般會員</option>
                                                <option value="2" <?= ($row["level_id"] == 2) ? 'selected' : '' ?>>白金會員</option>
                                                <option value="3" <?= ($row["level_id"] == 3) ? 'selected' : '' ?>>鑽石會員</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">聯絡電話</th>
                                        <td class="ps-5">
                                            <input type="text" class="form-control"
                                                name="phone"
                                                value="<?= $row["phone"] ?>">
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">生日</th>
                                        <td class="ps-5">
                                            <input type="date" class="form-control"
                                                name="birthday"
                                                value="<?= $row["birthday"] ?>">
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">信箱</th>
                                        <td class="ps-5">
                                            <input type="text" class="form-control"
                                                name="email"
                                                value="<?= $row["email"] ?>">
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">地址</th>
                                        <td class="ps-5">
                                            <input type="text" class="form-control"
                                                name="address"
                                                value="<?= $row["address"] ?>">
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="p-2 ps-4">註冊時間</th>
                                        <td class="ps-5">
                                            <?= $row["created_at"] ?>
                                        </td>
                                    </tr>

                                </table>
                        </div>
                    </div>
                    <div class="row mt-0 ms-2">
                        <!-- 上傳區塊 -->
                        <label for="form-label text-style">
                            <h5 class="align-middle">編輯頭像</h5>
                        </label>
                        <div class="col-4">
                            <input type="file" id="avatarUpload" name="meupload" class="form-control" onchange="previewAvatar()">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-dark" onclick="resetAvatar()"><i class="fa-solid fa-rotate-right"></i></button>
                        </div>
                        <div class="mb-3 d-flex justify-content-end gap-3 col-7">
                            <button class="btn btn-dark"
                                type="submit"><i class="fa-solid fa-floppy-disk px-2"></i>儲存</button>
                            <a class="btn btn-outline-danger" href="#" onclick="return confirmDelete(<?= $row['id'] ?>)">
                                <i class="fa-regular fa-trash-can px-2"></i>刪除
                            </a>
                        </div>
                    </div>
            </div>
            </form>
        <?php else : ?>
            會員不存在
        <?php endif; ?>
        </div>
        </div>
    </main>

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
                preview.src = "./upload/<?= $row["member_img"] ?>"; // 如果沒有選擇新圖片，保留預設圖片
            }
        }

        function resetAvatar() {
            document.getElementById('avatarUpload').value = ""; // 清空檔案
            document.getElementById('avatarPreview').src = "./upload/<?= $row["member_img"] ?>"; // 重置頭像預覽
        }
    </script>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>