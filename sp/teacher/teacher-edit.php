<?php

if (!isset($_GET["id"])) {
    echo "請正確帶入 get id 變數";
    exit;
}
$id = $_GET["id"];

require_once("../../db_connect.php");

$sql = "SELECT * FROM teachers
WHERE id ='$id' AND valid=1 ";

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
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("./css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>

    <main class="main-content px-3 pb-3 pt-5">
        <div class="container">
            <div class="mt-4 row d-flex justify-content-center align-items-center">
                <div class="col-10">

                    <h1 class="h2 mt-5 pt-5 mb-2">編輯資料</h1>
                    <div class="py-2">
                        <a class="btn btn-dark" href="teacher.php?id=<?= $row["id"] ?>" title="回教師清單">
                            <i class="fa-solid fa-arrow-left-long py-1 pe-2"></i>回教師資訊
                        </a>
                    </div>

                    <div class="mt-4 me-5 d-flex justify-content-between align-items-center">
                        <?php if ($userCount > 0) : ?>


                            <div class="col">

                                <form action="doUpdateTeacher.php" method="post" enctype="multipart/form-data">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="col-5">
                                            <div class="ratio ratio-1x1">
                                                <img id="imgPreviewArea" class="rounded object-fit-cover shadow-sm bg-secondary-subtle imgPreviewArea" src="./upload/<?= $row["main_picture"] ?>" alt="頭像圖片">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <table class="align-middle w-100">
                                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                <tr class="border-bottom d-none">
                                                    <th class="p-3 ps-4">id</th>
                                                    <td class="ps-5"><?= $row["id"] ?></td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="p-3 ps-4">帳號</th>
                                                    <td class="ps-5"><?= $row["account"] ?></td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="p-3 ps-4">姓名</th>
                                                    <td class="ps-5"><input type="text" class="form-control" name="name" value="<?= $row["name"] ?>"></td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="p-3 ps-4">Email</th>
                                                    <td class="ps-5"><input type="text" class="form-control" name="email" value="<?= $row["email"] ?>"></td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="p-3 ps-4">性別</th>
                                                    <td class="ps-5">
                                                        <div class="pt-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= $row["gender"] == 'male' ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="male">男</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= $row["gender"] == 'female' ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="female">女</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="p-3 ps-4">國籍</th>
                                                    <td class="ps-5"><input type="text" class="form-control" name="nation" value="<?= $row["nation"] ?>"></td>
                                                </tr>
                                                <tr class="border-bottom">
                                                    <th class="p-3 ps-4">資歷
                                                    </th>
                                                    <td class="ps-5"><input type="text" class="form-control" name="years" value="<?= $row["years"] ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th class="p-3 ps-4">註冊日期</th>
                                                    <td class="ps-5"><?= $row["created_at"] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="mt-4 d-flex justify-content-between">
                                        <div class=" ">
                                            <input type="file" name="pic" id="imgUpload" class="py-2 form-control" required onchange="previewImg()">
                                        </div>
                                        <div>
                                            <button class="btn btn-dark me-3" type="submit">
                                                <i class="me-2 py-1 fa-solid fa-floppy-disk"></i>儲存
                                            </button>
                                            <a class="btn btn-outline-danger" href="doDeleteTeacher.php?id=<?= $row["id"] ?>">
                                                <i class="me-2 py-1 fa-solid fa-trash"></i>刪除
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            使用者不存在
                        <?php endif; ?>
                    </div>



                </div>
            </div>
    </main>
    <?php include("./js.php") ?>

    <script>
        function previewImg() {
            let file = document.getElementById('imgUpload').files[0];
            let preview = document.getElementById('imgPreviewArea');

            const reader = new FileReader();
            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = " / upload / <?= $row["main_picture"] ?> "; // 如果沒有選擇新圖片，保留預設圖片
            }
        }
    </script>

</body>

<?php $conn->close(); ?>

</html>