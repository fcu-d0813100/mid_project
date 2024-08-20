<?php require_once("../../db_connect.php");

$sqlAll = "SELECT * FROM teachers WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$userCountAll = $resultAll->num_rows;

$page = 1;
$start_item = 0;
$per_page = 5;

$total_page = ceil($userCountAll / $per_page);

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM teachers WHERE account LIKE '%$search%' AND valid=1 ";
} elseif (isset($_GET["p"]) && isset($_GET["order"])) {
    $order = $_GET["order"];
    $page = $_GET["p"];
    $start_item = ($page - 1) * $per_page;

    switch ($order) {
        case 1:
            $where_clause = "ORDER BY years ASC"; //數字升冪
            break;
        case 2:
            $where_clause = "ORDER BY years DESC"; //數字降冪
            break;
        default:
            header("location:teachers.php?p=1&order=1");
            break;
    }
    $sql = "SELECT * FROM teachers WHERE valid=1 $where_clause LIMIT $start_item,$per_page";
} else {
    header("location:teachers.php?p=1&order=1");
    // $sql = "SELECT * FROM teachers WHERE valid=1 LIMIT $start_item,$per_page ";
}

// $sql = "SELECT * FROM teachers";
$result = $conn->query($sql);

if (isset($_GET["search"])) {
    $userCount = $result->num_rows;
} else {
    $userCount = $userCountAll;
};





?>
<!doctype html>
<html lang="en">

<head>
    <title>Teachers</title>
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
        <div class="container ">
            <div class="row d-flex justify-content-center align-items-center ">
                <div class="col-10">
                    <div>
                        <h1 class="h2 mt-5 pt-5 mb-3">師資列表</h1>

                        <div class="py-3">
                            <form action="">
                                <div class="input-group">
                                    <input type="search" class="form-control focus-ring focus-ring-secondary" name=" search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋教師">
                                    <button class="btn btn-dark" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="py-3 mt-2 mb-1 d-flex justify-content-between">

                            <div>
                                <?php if (isset($_GET["search"])) : ?>
                                    <a class="btn btn-dark me-3" href="teachers.php" title="回教師清單">
                                        <i class="fa-solid fa-arrow-left-long py-1 pe-2"></i>回教師清單
                                    </a>
                                <?php endif; ?>
                                <a class="btn btn-dark" href="create-teacher.php">
                                    <i class="fa-solid fa-user-plus py-1 pe-2"></i>新增教師
                                </a>
                            </div>
                            <div>
                                <div class="btn-group me-2">
                                    <a class="btn btn-dark border-end" href="">
                                        <i class="py-1 fa-solid fa-location-dot me-2"></i>國內
                                    </a>
                                    <a class="btn btn-dark border-start" href="">
                                        <i class="py-1 fa-solid fa-earth-americas me-2"></i>國際
                                    </a>
                                </div>
                                <?php if (isset($_GET["p"])): ?>
                                    <div class="btn-group">
                                        <a class="btn btn-dark border-end
                                        <?php if ($order == 1) echo "active" ?>" href="teachers.php?p=<?= $page ?>&order=1">
                                            <i class="py-1 fa-solid fa-arrow-down-1-9 me-2"></i>年資
                                        </a>
                                        <a class="btn btn-dark border-start
                                        <?php if ($order == 2) echo "active" ?>" href="teachers.php?p=<?= $page ?>&order=2">
                                            <i class="py-1 fa-solid fa-arrow-down-9-1 me-2"></i>年資
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <?php if ($userCount > 0) :
                                $rows = $result->fetch_all(MYSQLI_ASSOC);
                            ?>
                                <table class="table table-bordered  table-style text-center align-middle">
                                    <thead>

                                        <tr>
                                            <th class="bg-body-secondary fw-semibold">ID</th>
                                            <th class="bg-body-secondary fw-semibold name-style">姓名</th>
                                            <th class="bg-body-secondary fw-semibold">性別</th>
                                            <th class="bg-body-secondary fw-semibold">Email</th>
                                            <th class="bg-body-secondary fw-semibold">彩妝年資</th>
                                            <th class="bg-body-secondary fw-semibold">國籍</th>
                                            <th class="bg-body-secondary fw-semibold"></th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        <?php foreach ($rows as $teacher): ?>
                                            <tr>
                                                <td><?= $teacher["id"] ?></td>
                                                <td><?= $teacher["name"] ?></td>

                                                <?php if ($teacher["gender"] == "male") {
                                                    $teacher["gender"] = "男";
                                                } else {
                                                    $teacher["gender"] = "女";
                                                }
                                                ?>
                                                <td><?= $teacher["gender"] ?></td>
                                                <td><?= $teacher["email"] ?></td>
                                                <td><?= $teacher["years"] ?></td>
                                                <td><?= $teacher["nation"] ?></td>
                                                <td class="col-auto ">
                                                    <a class="btn btn-outline-danger " href="teacher.php?id=<?= $teacher["id"] ?>"><i class="py-1 pe-2 fa-regular fa-eye"></i>檢視</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between">

                            <?php if (isset($_GET["p"])) : ?>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php for ($i = 1; $i <= $total_page; $i++): ?>
                                            <li class="page-item 
                                        <?php if ($page == $i)
                                                echo "active";
                                        ?>
                                        "><a class="page-link px-3" href="teachers.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
                                        <?php endfor; ?>
                                    </ul>
                                </nav>
                            <?php endif; ?>

                            <?php if ($userCount > 0) : ?>
                                <p class="m-0 text-end">共有 <?= $userCountAll ?> 個使用者</p>
                            <?php else : ?>
                                目前沒有使用者
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
    </main>

    <?php include("./js.php") ?>
</body>
<?php $conn->close(); ?>

</html>