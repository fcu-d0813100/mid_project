<?php
require_once("../../db_connect.php");

$sqlAll = "SELECT * FROM users WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$userCountAll = $resultAll->num_rows;


// 
// $sqlUserLevel = "SELECT users.*, user_level.name AS level_name
//         FROM users
//         JOIN user_level ON users.level_id = user_level.id
//         WHERE valid = 1
//         LIMIT $start_item, $per_page";

// $userResult = $conn->query($sqlUserLevel);
// $userRows = $userResult->fetch_all(MYSQLI_ASSOC); // 取得所有資料列

$page = 1;
$start_item = 0;
$per_page = 10;
// 每頁顯示10筆資料

$total_page = ceil($userCountAll / $per_page);
// echo "total page: $total_page";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM users WHERE name LIKE '%$search%' AND valid=1";
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
            // 這邊可以調整升冪跟降冪的名稱
        case 5:
            $where_clause = " ORDER BY created_at ASC";
            break;
        case 6:
            $where_clause = " ORDER BY created_at DESC";
            break;
        default:
            header("location: users.php?p=1&order=1");
            break;
    }

    // 連接level_name
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
    <?php include("css.php") ?>
</head>

<body>
    <?php include("../../nav1.php") ?>
    <main class="main-content ">
        <div class="d-flex justify-content-between align-items-start mt-3">
            <p class="m-0 d-inline text-lg text-secondary">會員管理 /<span class="text-sm">會員列表</span></p>
        </div>
        <div class="container">
            <div class="py-2">
                <?php if (isset($_GET["search"])) : ?>
                    <a class="btn btn-primary" href="users.php" title="回到會員列表"><i class="fa-solid fa-left-long"></i></a>
                <?php endif; ?>
                <a class="btn btn-primary" href="create-user.php"><i class="fa-solid fa-user-plus pe-2"></i>新增會員</a>
            </div>

            <div class="py-2">
                <form action="">
                    <div class="input-group">
                        <input type="search" class="form-control" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋關鍵字">
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass pe-2"></i>搜尋</button>
                    </div>
                </form>
            </div>
            <?php if (isset($_GET["p"])): ?>
                <div class="py-2 d-flex justify-content-end">
                    <div class="btn-group">
                        <!-- 排序ID(由小到大)由大到小 利用order by -->
                        <a class="btn btn-primary"
                            <?php if ($order == 1) echo "active" ?>
                            href="users.php?p=<?= $page ?>&order=1">id升冪排序</a>
                        <a class="btn btn-primary"
                            <?php if ($order == 2) echo "active" ?>
                            href="users.php?p=<?= $page ?>&order=2">id降冪降冪</a>
                        <a class="btn btn-primary"
                            <?php if ($order == 3) echo "active" ?>
                            href="users.php?p=<?= $page ?>&order=3">依照會員等級排序(低)</a>
                        <a class="btn btn-primary"
                            <?php if ($order == 4) echo "active" ?>
                            href="users.php?p=<?= $page ?>&order=4">依照會員等級排序(高)</a>
                        <a class="btn btn-primary"
                            <?php if ($order == 5) echo "active" ?>
                            href="users.php?p=<?= $page ?>&order=5">依照註冊時間排序(最新)</a>
                        <a class="btn btn-primary"
                            <?php if ($order == 6) echo "active" ?>
                            href="users.php?p=<?= $page ?>&order=6">依照註冊時間排序(最晚)</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($userCount > 0) :
                $rows = $result->fetch_all(MYSQLI_ASSOC);
            ?>
                <p>第 <?= $page ?> 頁，共 <?= $total_page ?> 頁，每頁顯示<?= $per_page ?>筆，共 <?= $userCount ?>筆</p>

                <table class="table table-bordered">
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
                            <th></th>
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
                                <td>
                                    <a class="btn btn-primary" href="user.php?id=<?= $user["id"] ?>">詳細<i class="ms-2 fa-solid fa-eye"></i>
                                    </a>
                                    <a class="btn btn-primary" href="user-edit.php?id=<?= $user["id"] ?>">編輯<i class="ms-2 fa-solid fa-pen-to-square"></i></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (isset($_GET["p"])) : ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link cursor-pointer" <?php if ($page > 1) : ?> href="users.php?p=<?= $page - 1 ?>&order=<?= $order ?>" <?php endif; ?> aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                                <li class="page-item <?php
                                                        if ($page == $i) echo "active";
                                                        ?>"><a class="page-link" href="users.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item">
                                <a class="page-link" href="users.php?p=<?= $page + 1 ?>&order=<?= $order ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else : ?>
                搜尋不到使用者
            <?php endif; ?>
        </div>
    </main>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/front.js"></script>
    <script>
        const sortButtons = document.querySelectorAll('.sort');


        sortButtons.forEach(button => {
            button.addEventListener('click', () => {

                const icon = button.querySelector('i');


                if (icon.classList.contains('fa-sort-down')) {

                    icon.classList.remove('fa-sort-down');
                    icon.classList.add('fa-sort-up');
                } else {

                    icon.classList.remove('fa-sort-up');
                    icon.classList.add('fa-sort-down');
                }
            });
        });
    </script>
</body>
<?php $conn->close(); ?>

</html>