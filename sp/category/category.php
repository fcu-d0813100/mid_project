<?php
require_once("../../db_connect.php");

// 確定當前頁碼，並確保它是有效的整數
$page = isset($_GET["p"]) ? (int)$_GET["p"] : 1;
$page = $page > 0 ? $page : 1; // 確保頁碼不為負數
$per_page = 6; // 每頁顯示的項目數量
$start_item = ($page - 1) * $per_page;

// 確定排序方式
$order = isset($_GET["order"]) ? (int)$_GET["order"] : 1;
switch ($order) {
  case 1:
    $order_clause = "ORDER BY sub_category.id ASC";
    break;
  case 2:
    $order_clause = "ORDER BY sub_category.id DESC";
    break;
  default:
    $order_clause = "ORDER BY sub_category.id ASC";
    break;
}

// 搜尋關鍵字
$search = isset($_GET["search"]) ? $conn->real_escape_string($_GET["search"]) : '';
$main_category_id = isset($_GET["main_category_id"]) ? (int)$_GET["main_category_id"] : 0;

// 根據搜尋關鍵字和主分類 ID 修改 SQL 查詢
if ($search || $main_category_id) {
  $sqlAll = "SELECT COUNT(*) as total FROM sub_category
               WHERE name LIKE '%$search%'
               AND ($main_category_id = 0 OR main_category_id = $main_category_id)";
  $sql = "SELECT sub_category.id, sub_category.name AS sub_name, main_category.name AS main_name
            FROM sub_category
            JOIN main_category ON sub_category.main_category_id = main_category.id
            WHERE sub_category.name LIKE '%$search%'
            AND ($main_category_id = 0 OR sub_category.main_category_id = $main_category_id)
            $order_clause
            LIMIT $start_item, $per_page";
} else {
  $sqlAll = "SELECT COUNT(*) as total FROM sub_category";
  $sql = "SELECT sub_category.id, sub_category.name AS sub_name, main_category.name AS main_name
            FROM sub_category
            JOIN main_category ON sub_category.main_category_id = main_category.id
            $order_clause
            LIMIT $start_item, $per_page";
}

// 獲取總項目數
$resultAll = $conn->query($sqlAll);

if ($resultAll) {
  $row = $resultAll->fetch_assoc();
  $subCountAll = $row['total'];
} else {
  die("Error: " . $conn->error);
}

// 計算總頁數
$total_page = ceil($subCountAll / $per_page);

// 查詢當前頁面資料
$result = $conn->query($sql);

if (!$result) {
  die("Error: " . $conn->error);
}

// 獲取主分類列表
$main_categories = $conn->query("SELECT id, name FROM main_category");

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>品項管理</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <?php include("./css.php") ?>
</head>

<body>
  <?php include("../../nav1.php") ?>
  <main class="main-content ">
    <div class="container">
      <div class=" mt-5">
        <p class="m-0 d-inline h2">類別管理 <span class="text-sm fs-5"> / 品項管理</span></p>
      </div>
      <div class="py-2">
        <?php if (!empty($_GET["search"]) && empty($_GET["main_category_id"]) && empty($_GET["order"])) : ?>
          <a class="btn btn-dark" href="category.php" title="回列表"><i class="fa-solid fa-left-long"></i> 返回列表</a>
        <?php endif; ?>

      </div>
      <div class="py-2">

        <form action="" method="get">
          <div class="input-group">
            <input type="search" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="搜尋品項">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
      </div>
      <div class="py-2">

      </div>
      <div class="py-2 mb-2 d-flex justify-content-between">
        <a class="btn btn-dark" href="create-category.php"><i class="fa-solid fa-plus me-2"></i>新增品項</a>
        <div class="d-flex justify-content-between">
          <form action="" method="get">
            <div class="me-3">
              <select class="form-control" name="main_category_id" onchange="this.form.submit()">
                <option value="0" <?= $main_category_id == 0 ? 'selected' : '' ?>>全部分類 </option>
                <?php while ($category = $main_categories->fetch_assoc()) : ?>
                  <option value="<?= $category['id'] ?>" <?= $main_category_id == $category['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
              <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
              <input type="hidden" name="order" value="<?php echo $order; ?>">
            </div>
          </form>
          <div class="btn-group">
            <a class="btn btn-dark border-end <?= ($order == 1) ? "active" : "" ?>" href="category.php?p=<?= $page ?>&order=1&main_category_id=<?= $main_category_id ?>&search=<?= htmlspecialchars($search) ?>">
              <i class="fa-solid fa-arrow-down-1-9"></i> ID正序
            </a>
            <a class="btn btn-dark border-start <?= ($order == 2) ? "active" : "" ?>" href="category.php?p=<?= $page ?>&order=2&main_category_id=<?= $main_category_id ?>&search=<?= htmlspecialchars($search) ?>">
              <i class="fa-solid fa-arrow-down-9-1"></i> ID倒序
            </a>
            <!-- Add more sorting options here if needed -->
          </div>
        </div>
      </div>
      <?php if ($subCountAll > 0) :
        $rows = $result->fetch_all(MYSQLI_ASSOC);
      ?>
        共有 <?= $subCountAll ?> 個品項
        <table class="table table-bordered mt-2 text-center">
          <thead>
            <tr>
              <th class="col-1">編號</th>
              <th>部位分類</th>
              <th>品項名稱</th>
              <th class="col-3">修改刪除</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $category) : ?>
              <tr>
                <td><?= $category["id"] ?></td>
                <td><?= $category["main_name"] ?></td>
                <td><?= $category["sub_name"] ?></td>
                <td>
                  <a class="btn btn-dark me-3" href="category-edit.php?id=<?= $category["id"] ?>">修改</a>
                  <a class="btn btn-outline-danger" href="doDeleteCategory.php?id=<?= $category["id"] ?>" onclick="return confirm('是否確定刪除?')">刪除</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php if (!$search) : ?>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                <li class="page-item <?= ($page == $i) ? "active" : "" ?>">
                  <a class="page-link" href="category.php?p=<?= $i ?>&order=<?= $order ?>&main_category_id=<?= $main_category_id ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php endif; ?>
      <?php else : ?>
        <div class="py-3">
          目前沒有此品項
        </div>
      <?php endif; ?>
    </div>
  </main>
  <?php $conn->close(); ?>
  </div>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>