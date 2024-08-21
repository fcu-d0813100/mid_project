<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: sign-in.php");
    exit;
}
?>

<?php
require_once("../../db_connect.php");

$sqlAll = "SELECT * FROM users WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$userCountAll = $resultAll->num_rows;

$page = 1;
$start_item = 0;
$per_page = 10;
// 每頁顯示10筆資料

$total_page = ceil($userCountAll / $per_page);
// echo "total page: $total_page";


if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT users.* , user_level.name AS level_name 
    FROM users 
    JOIN user_level ON users.level_id = user_level.id 
    WHERE users.id = '$search' OR users.name LIKE '%$search%' AND users.valid=1";
} elseif (isset($_GET["p"]) && isset($_GET["order"])) {
    $order = $_GET["order"];
    $page = $_GET["p"];
    $start_item = ($page - 1) * $per_page;

    switch ($order) {
        case 1:
            $where_clause = " ORDER BY id ASC";
            break;
        case 2:
            $where_clause = " ORDER BY id  DESC";
            break;
        case 3:
            $where_clause = " ORDER BY level_id ASC";
            break;
        case 4:
            $where_clause = " ORDER BY level_id DESC";
            break;

        default:
            header("location: users.php?p=1&order=1");
            break;
    }

    // JOIN level_name
    $sql = "SELECT users.* , user_level.name AS level_name FROM users
    JOIN user_level ON users.level_id = user_level.id
    WHERE valid=1 $where_clause LIMIT $start_item, $per_page";

    // $sql = "SELECT * FROM users WHERE valid=1 LIMIT $start_item, $per_page";
} else {

    header("location: users.php?p=1&order=1");
    // $sql = "SELECT * FROM users WHERE valid=1 LIMIT $start_item, $per_page";
}

$result = $conn->query($sql);


if (isset($_GET["search"])) {
    $userCount = $result->num_rows;
} else {
    $userCount = $userCountAll;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Users</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="noindex">
    <!-- theme stylesheet-->

    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../css/style.default.premium.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="../css/custom.css">
    <!-- font-awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content bg-light">
        <div class="mx-2">
            <div class="row d-flex justify-content-between">
                <div class="mt-3 col-md-3">
                    <p class="m-0 d-inline text-lg text-secondary">會員管理 /<span class="text-sm">會員列表</span></p>
                </div>
                <div class="mt-3 col-md-3 d-flex justify-content-end pe-5">
                    <a class="btn btn-primary" href="create-user.php"><i class="fa-solid fa-user-plus pe-2"></i>新增會員</a>
                </div>
            </div>
            <hr>

            <!-- 搜尋 -->
            <div class="row mb-2">
                <div class=" col-md-4">
                    <form action="">
                        <div class="input-group">
                            <input type="search" class="form-control" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋ID、姓名關鍵字">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass pe-2"></i>搜尋</button>
                            <?php if (isset($_GET["search"])) : ?>
                                <a class="btn btn-primary ms-1" href="users.php" title="回到會員列表"><i class="fa-solid fa-rotate-right"></i></a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="d-flex justify-content-center align-items-center col-md-4">
                    <p class="h5">第 <?= $page ?> 頁，共 <?= $total_page ?> 頁，每頁顯示<?= $per_page ?>筆，共 <?= $userCount ?>筆</p>
                </div>


                <?php if (isset($_GET["p"])): ?>
                    <div class="d-flex justify-content-end col-md-4">
                        <div class="btn-group">
                            <!-- 排序ID(由小到大)由大到小 利用order by -->
                            <a class="btn btn-primary mx-1"
                                <?php if ($order == 1) echo "active" ?>
                                href="users.php?p=<?= $page ?>&order=1">ID<i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a class="btn btn-primary "
                                <?php if ($order == 2) echo "active" ?>
                                href="users.php?p=<?= $page ?>&order=2">ID<i class="fa-solid fa-arrow-down-wide-short"></i></a>
                            <a class="btn btn-primary mx-1"
                                <?php if ($order == 3) echo "active" ?>
                                href="users.php?p=<?= $page ?>&order=3">會員等級<i class="fa-solid fa-arrow-down-short-wide"></i></a>
                            <a class="btn btn-primary"
                                <?php if ($order == 4) echo "active" ?>
                                href="users.php?p=<?= $page ?>&order=4">會員等級<i class="fa-solid fa-arrow-down-wide-short"></i></a>

                        </div>
                    </div>
            </div>
        <?php endif; ?>
        <?php if ($userCount > 0) :
            $rows = $result->fetch_all(MYSQLI_ASSOC);

        ?>


            <table class="table table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>性別</th>
                        <th>電話</th>
                        <th>生日</th>
                        <th>信箱</th>
                        <th>註冊時間</th>
                        <th>會員等級</th>
                        <th>檢視及編輯</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $user) : ?>
                        <tr>
                            <td><?= $user["id"] ?></td>
                            <td><?= $user["name"] ?></td>
                            <td><?= ($user["gender"] == 1) ? '男' : '女' ?></td>
                            <td><?= $user["phone"] ?></td>
                            <td><?= $user["birthday"] ?></td>
                            <td><?= $user["email"] ?></td>
                            <td><?= $user["created_at"] ?></td>
                            <td><?= $user["level_name"] ?></td>
                            <td class="text-md">
                                <a class="btn btn-primary text-sm" href="user.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i>
                                </a>
                                <a class="btn btn-primary text-sm" href="user-edit.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (isset($_GET["p"])) : ?>
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link cursor-pointer" <?php if ($page > 1) : ?> href="users.php?p=<?= $page - 1 ?>&order=<?= $order ?>" <?php endif; ?> aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                            <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="users.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                        <li class="page-item">
                            <a class="page-link" <?php if ($page < $total_page) : ?> href="users.php?p=<?= $page + 1 ?>&order=<?= $order ?>" <?php endif; ?> aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            <?php endif; ?>
        <?php else : ?>
            搜尋不到會員資料
        <?php endif; ?>
        </div>
    </main>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>
<?php $conn->close(); ?>

</html>