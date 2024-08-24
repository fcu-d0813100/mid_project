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
    WHERE users.valid = 1 AND (users.id LIKE '%$search%' OR users.name LIKE '%$search%')";
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

    <?php include("css.php") ?>

    <style>
        body {
            background-color: #f5f5f5;
        }
    </style>

</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content">
        <div class="container">
            <div class="mx-2">
                <div class="row d-flex justify-content-between mt-2">
                    <div class="mt-3 col-md-3">
                        <p class="m-0 d-inline h2">會員管理 <span class="text-sm fs-5"> / 會員列表</span></p>
                    </div>
                    <div class="mt-3 col-md-3 d-flex justify-content-end pe-5">
                        <a class="btn btn-dark" href="create-user.php"><i class="fa-solid fa-user-plus pe-2"></i>新增會員</a>
                    </div>
                </div>
                <hr>

                <!-- 搜尋 -->
                <div class="row mb-2 py-3">
                    <div class=" col-md-4">
                        <form action="">
                            <div class="input-group">
                                <input type="search" class="form-control" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋ID、姓名關鍵字">
                                <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <?php if (isset($_GET["search"])) : ?>
                                    <a class="btn btn-dark" href="users.php" title="回到會員列表"><i class="fa-solid fa-rotate-right"></i></a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <?php if (isset($_GET["search"])): ?>
                        <div class="d-flex justify-content-center align-items-center col-md-4">
                            <p class="text-md">共有<?= $userCount ?>筆會員資料</p>
                        </div>
                    <?php else: ?>
                        <div class="d-flex justify-content-center align-items-center col-md-4">
                            <p class="text-md m-0">第 <?= $page ?> 頁，共 <?= $total_page ?> 頁，每頁顯示<?= $per_page ?>筆，共<?= $userCount ?>筆</p>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET["search"]) || isset($_GET["p"])):
                        $order = isset($_GET['order']) ? $_GET['order'] : 1; ?>
                        <!-- 讓他先有個值:1 搜尋時篩選的按鈕也能存在 -->
                        <div class="d-flex justify-content-end col-md-4">
                            <div class="btn-group">
                                <!-- 排序ID(由小到大)由大到小 利用order by -->
                                <a class="btn btn-dark border-end"
                                    <?php if ($order == 1) echo "active" ?>
                                    href="users.php?p=<?= $page ?>&order=1">ID<i class="fa-solid fa-arrow-down-short-wide ms-2"></i></a>
                                <a class="btn btn-dark border-start border-end"
                                    <?php if ($order == 2) echo "active" ?>
                                    href="users.php?p=<?= $page ?>&order=2">ID<i class="fa-solid fa-arrow-down-wide-short ms-2"></i></a>
                                <a class="btn btn-dark border-end border-start"
                                    <?php if ($order == 3) echo "active" ?>
                                    href="users.php?p=<?= $page ?>&order=3">會員等級<i class="fa-solid fa-arrow-down-short-wide ms-2"></i></a>
                                <a class="btn btn-dark border-start"
                                    <?php if ($order == 4) echo "active" ?>
                                    href="users.php?p=<?= $page ?>&order=4">會員等級<i class="fa-solid fa-arrow-down-wide-short ms-2"></i></a>

                            </div>
                        </div>
                </div>
            <?php endif; ?>
            <?php if ($userCount > 0) :
                $rows = $result->fetch_all(MYSQLI_ASSOC);
            ?>
            </div>
        </div>
        </div>
    <?php endif; ?>

    <table class="table table-hover text-center align-middle mt-3 ">
        <thead class="">
            <tr>

                <th>ID</th>
                <th>姓名</th>
                <th>性別</th>
                <th>電話</th>
                <th>生日</th>
                <th>信箱</th>
                <th>註冊時間</th>
                <th>會員等級</th>
                <th>檢視 <span></span> <span></span><span></span>編輯</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $user) : ?>
                <tr class=" align-middle">
                    <td><?= $user["id"] ?></td>
                    <td><?= $user["name"] ?></td>
                    <td><?= ($user["gender"] == 1) ? '男' : '女' ?></td>
                    <td><?= $user["phone"] ?></td>
                    <td><?= $user["birthday"] ?></td>
                    <td><?= $user["email"] ?></td>
                    <td><?= $user["created_at"] ?></td>
                    <td><?= $user["level_name"] ?></td>
                    <td class="text-md">
                        <a class="btn btn-outline-danger text-sm" href="user.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-eye"></i>
                        </a>
                        <a class="btn btn-outline-danger text-sm" href="user-edit.php?id=<?= $user["id"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
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
    <?php if ($userCount > 0) :
        $rows = $result->fetch_all(MYSQLI_ASSOC);

    ?>



    <?php else : ?>
        搜尋不到資料
    <?php endif; ?>
    </div>
    </div>
    </main>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
</body>
<?php $conn->close(); ?>

</html>