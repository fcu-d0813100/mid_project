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
    <title><?= $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("css.php") ?>
    <script>
        function confirmDelete(id) {
            var confirmation = confirm("您確定要刪除這筆資料嗎?");
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

        .avatar-preview {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content ">
        <div class="d-flex justify-content-between align-items-start mt-3">
            <p class="m-0 d-inline text-lg text-secondary">會員管理 /<span class="text-sm">會員列表</span></p>
        </div>

        <div class="container">
            <div class="py-2">
                <a class="btn btn-outline-secondary" href="user.php?id=<?= $row["id"] ?>" title="返回會員列表"><i class="fa-solid fa-left-long"></i></a>
            </div>
            <div class="row ">
                <div class="col-lg-4">
                    <h1>修改會員資料</h1>
                    <?php if ($userCount > 0) : ?>
                        <form action="doUpdateUser.php" method="post" enctype="multipart/form-data">
                            <table class="table table-bordered">
                                <input type="hidden" name="id"
                                    value="<?= $row["id"] ?>">
                                <tr>
                                    <th>ID</th>
                                    <td><?= $row["id"] ?></td>
                                </tr>
                                <tr>
                                    <th>帳號</th>
                                    <td><?= $row["account"] ?></td>
                                </tr>
                                <tr>
                                    <th>姓名</th>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="name"
                                            value="<?= $row["name"] ?>">
                                    </td>
                                </tr>

                                <tr>
                                    <th>性別</th>
                                    <td>
                                        <div>
                                            <input type="radio" id="male" name="gender" value="1" <?= ($row["gender"] == 1) ? 'checked' : '' ?>>
                                            <label for="male">男</label>
                                            <input type="radio" id="female" name="gender" value="2" <?= ($row["gender"] == 2) ? 'checked' : '' ?>>
                                            <label for="female">女</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>會員等級</th>
                                    <td>
                                        <select class="form-control" name="level_id">
                                            <option value="1" <?= ($row["level_id"] == 1) ? 'selected' : '' ?>>一般會員</option>
                                            <option value="2" <?= ($row["level_id"] == 2) ? 'selected' : '' ?>>白金會員</option>
                                            <option value="3" <?= ($row["level_id"] == 3) ? 'selected' : '' ?>>鑽石會員</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>聯絡電話</th>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="phone"
                                            value="<?= $row["phone"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>生日</th>
                                    <td>
                                        <input type="date" class="form-control"
                                            name="birthday"
                                            value="<?= $row["birthday"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>信箱</th>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="email"
                                            value="<?= $row["email"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th>地址</th>
                                    <td>
                                        <input type="text" class="form-control"
                                            name="address"
                                            value="<?= $row["address"] ?>">
                                    </td>
                                </tr>

                            </table>

                            <div class="row mb-3 d-flex align-items-center">
                                <!-- 上傳區塊 -->
                                <label for="form-label text-style">上傳會員頭像</label>
                                <div class="col">
                                    <input type="file" id="avatarUpload" name="meupload" class="form-control" onchange="previewAvatar()">
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-dark" onclick="resetAvatar()"><i class="fa-solid fa-rotate-right"></i></button>
                                </div>
                            </div>

                            <h2>會員照片</h2>
                            <img src="./upload/<?= $row["member_img"] ?>" alt="" class="img-fluid" id="avatarPreview">
                            <div class="">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary"
                                        type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                                    <a class="btn btn-danger" href="#" onclick="return confirmDelete(<?= $row['id'] ?>)">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>
                        </form>
                    <?php else : ?>
                        使用者不存在
                    <?php endif; ?>
                </div>
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

        // function resetAvatar() {
        //     document.getElementById('avatarUpload').value = ""; // 清空檔案
        //     document.getElementById('avatarPreview').src = "./upload/avatar01.jpg"; // 重置頭像預覽
        // }
    </script>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>

</html>