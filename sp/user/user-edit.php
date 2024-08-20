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
</head>

<body>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="user.php?id=<?= $row["id"] ?>" title="返回會員列表"><i class="fa-solid fa-left-long"></i></a>
        </div>
        <div class="row ">
            <div class="col-lg-4">
                <h1>修改會員資料</h1>
                <?php if ($userCount > 0) : ?>
                    <form action="doUpdateUser.php" method="post">
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
                                        <option value="2" <?= ($row["level_id"] == 2) ? 'selected' : '' ?>>VIP</option>
                                        <option value="3" <?= ($row["level_id"] == 3) ? 'selected' : '' ?>>管理員</option>
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
                        <h2>會員照片</h2>
                        <img src="./upload/<?= $row["member_img"] ?>" alt="" class="img-fluid">
                        <div class="">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary"
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

</body>

</html>