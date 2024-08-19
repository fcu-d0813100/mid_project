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

    <?php include("../../css.php") ?>
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
                                <td><?= ($row["gender"] == 1) ? '男' : '女' ?></td>
                            </tr>





                            <tr>
                                <th>會員等級</th>
                                <td> <select class="form-control" name="level_id">

                                        <option value="1">一般會員</option>
                                        <option value="2">VIP</option>
                                        <option value="3">管理員</option>
                                    </select>
                                    <!-- </td>

                                <td><?= $row["level_name"] ?>



                                </td> -->
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
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary"
                                type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                            <a class="btn btn-danger" href="doDeleteUser.php?id=<?= $row["id"] ?>">
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