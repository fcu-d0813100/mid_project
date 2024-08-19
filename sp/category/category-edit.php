<?php
require_once("./productdb_connect.php");

// 確保傳遞的ID有效
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
if ($id <= 0) {
    die("無效的ID");
}

// 獲取要編輯的類別資料
$sql = "SELECT sub_category.id, sub_category.name AS sub_name, sub_category.main_category_id, main_category.name AS main_name
        FROM sub_category
        JOIN main_category ON sub_category.main_category_id = main_category.id
        WHERE sub_category.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("找不到該類別");
}

$category = $result->fetch_assoc();

// 獲取主分類列表
$main_categories = $conn->query("SELECT id, name FROM main_category");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 更新資料
    $sub_name = $_POST["sub_name"];
    $main_category_id = (int)$_POST["main_category_id"];

    $update_sql = "UPDATE sub_category SET name = ?, main_category_id = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sii", $sub_name, $main_category_id, $id);

    if ($update_stmt->execute()) {
        header("Location: category.php");
        exit();
    } else {
        die("更新失敗: " . $conn->error);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>文章列表</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
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
    <main class="main-content ">
        <div class="container">
            <h3>編輯類別</h3>
            <form action="" method="post">
                <div class="form-group">
                    <label for="sub_name">品項名稱</label>
                    <input type="text" class="form-control" id="sub_name" name="sub_name" value="<?= htmlspecialchars($category["sub_name"]) ?>" required>
                </div>
                <div class="form-group">
                    <label for="main_category_id">部位分類</label>
                    <select class="form-control" id="main_category_id" name="main_category_id" required>
                        <?php while ($main_category = $main_categories->fetch_assoc()) : ?>
                            <option value="<?= $main_category['id'] ?>" <?= $main_category['id'] == $category['main_category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($main_category['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">保存</button>
                <a class="btn btn-secondary" href="category.php">取消</a>
            </form>
        </div>
    </main>


    </div>


    <script>
        function sortTable(orderType) {
            var page = <?= $page ?>;
            var url = "article-list.php?p=" + page + "&order=" + orderType;
            window.location.href = url;
        }
    </script>


    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>
<?php $conn->close(); ?>