<?php
require_once("../../db_connect.php");

// 獲取文章總數
$sqlAll = "SELECT * FROM article WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$articleCountAll = $resultAll->num_rows;

$page = 1;
$per_page = 5;
$start_item = 0;

$total_page = ceil($articleCountAll / $per_page);

$order = 1;
if (isset($_GET["order"])) {
  $order = $_GET["order"];
}

if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $sql = "SELECT 
        article.*,  
        brand.name AS brand_name,
        article_type.name AS type_name
        FROM article
        JOIN brand ON article.brand_id = brand.id
        JOIN article_type ON article.type_id = article_type.id 
        WHERE article.valid = 1 AND article.title LIKE '%$search%'
        LIMIT $start_item, $per_page";
  $result = $conn->query($sql);
  $articleCount = $result->num_rows;
} elseif (isset($_GET["p"]) && isset($_GET["order"])) {
  $order = $_GET["order"];
  switch ($order) {
    case 1:
      $where_clause = " WHERE article.valid = 1 ORDER BY id ASC";
      break;
    case 2:
      $where_clause = " WHERE article.valid = 1 ORDER BY id DESC";
      break;
    case 3:
      $where_clause = " WHERE article.valid = 1 ORDER BY launched_date ASC";
      break;
    case 4:
      $where_clause = " WHERE article.valid = 1 ORDER BY launched_date DESC";
      break;
    default:  //用戶打其他變數，統一回列表
      header("location:article-list.php?p=1&order=1");
      break;
  }

  $page = $_GET["p"];
  $start_item = ($page - 1) * $per_page;
  $sql = "SELECT 
        article.*,  
        brand.name AS brand_name,
        article_type.name AS type_name
        FROM article
        JOIN brand ON article.brand_id = brand.id
        JOIN article_type ON article.type_id = article_type.id 
        $where_clause
        LIMIT $start_item, $per_page";
  $result = $conn->query($sql);
  $articleCount = $articleCountAll;
} else {
  header("location:article-list.php?p=1&order=1");
}
// $rows = $result->fetch_all(MYSQLI_ASSOC);
$result = $conn->query($sql);
$articleCount = $articleCountAll;
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

  <?php include("./css.php") ?>

  </style>
</head>

<body>
  <?php include("../../nav1.php") ?>
  <main class="main-content main-content d-flex justify-content-center">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-between align-items-start pt-5 mt-3">

            <div>
              <p class="m-0 d-inline text-lg h2">文章管理 <span class="text-sm fs-5"> / 文章列表</span></p>
            </div>
            <div class="d-flex justify-content-between gap-2">
              <?php if (isset($_GET["search"])): ?>
                <a href="article-list.php" class="btn btn-dark" title="回文章列表"><i class="fa-solid fa-left-long"></i></a>
              <?php endif; ?>
              <!-- sort search -->
              <form action="">
                <div class="input-group">
                  <input type="search" class="form-control  border-secondary" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="搜尋標題">
                  <button class="btn btn-dark border-start-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
              </form>
              <div>
                <!-- add button -->
                <div class="text-end">
                  <a href="article-create.php" class="btn btn-dark btn-md "><i class="fa-solid fa-plus"></i> 新增</a>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <!-- table-->
          <div class="table-responsive large">

            <div class="d-flex justify-content-between my-3">
              <?php if ($articleCount > 0):
                $rows = $result->fetch_all(MYSQLI_ASSOC) ?>
                共有<?= $articleCount ?> 則文章
                <!-- sort button -->
                <div class="btn-group btn-group-md">
                  <!-- 排序ID(由小到大)由大到小 利用order by -->
                  <a class="btn btn-outline-danger <?php if ($order == 1) echo "active" ?> "
                    href="article-list.php?p=<?= $page ?>&order=1">按編號<i class="fa-solid fa-arrow-up-long ms-2"></i></a>
                  <a class="btn btn-outline-danger <?php if ($order == 2) echo "active" ?> "
                    href="article-list.php?p=<?= $page ?>&order=2">按編號<i class="fa-solid fa-arrow-down-long ms-2"></i></a>
                  <a class="btn btn-outline-danger <?php if ($order == 3) echo "active" ?> "
                    href="article-list.php?p=<?= $page ?>&order=3">按發布時間<i class="fa-solid fa-arrow-up-long ms-2"></i></a>
                  <a class="btn btn-outline-danger <?php if ($order == 4) echo "active" ?> "
                    href="article-list.php?p=<?= $page ?>&order=4">按發布時間<i class="fa-solid fa-arrow-down-long ms-2"></i></a>
                </div>
            </div>
            <table class="table table-striped table-md text-md">
              <thead>
                <tr>
                  <th scope="col" class="col-1">編號
                    <!-- <div class="btn-group">
                <a href="javascript:void(0)" onclick="sortTable(1)" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-up-long"></i></a>
                <a href="javascript:void(0)" onclick="sortTable(2)" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-down-long"></i></a>
              </div> -->
                  </th>
                  <th scope="col" class="col-1">品牌</th>
                  <th scope="col" class="col-1">類型</th>
                  <th scope="col" class="col-3">標題</th>
                  <th scope="col">圖片</th>
                  <th scope="col" class="col-2">發布時間
                    <!-- <a href="javascript:void(0)" onclick="sortTable(3)" class="btn btn-outline-secondary btn-sm mb-1"><i class="fa-solid fa-sort"></i></a>
              <a href="javascript:void(0)" onclick="sortTable(4)" class="btn btn-outline-secondary btn-sm mb-1"><i class="fa-solid fa-sort"></i></a> -->

                  </th>
                  <th scope="col" class="col-2">動作</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($rows as $row) : ?>
                  <tr class="align-middle dataList">
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["brand_name"] ?></td>
                    <td><?= $row["type_name"] ?></td>
                    <td class="article-title"><?= $row["title"] ?></td>
                    <td class="ratio ratio-4x3 activePic"><img class="object-fit-cover p-3" src="./pic/<?= $row["main_pic"] ?>" alt=""></td>
                    <td><?= $row["launched_date"] ?></td>
                    <td class="gap-3">
                      <a href="article-review.php?id=<?= $row["id"] ?>" class="btn  btn-outline-danger btn-md">
                        <i class="fa-regular fa-eye"></i>
                      </a>
                      <a href="article-edit.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger btn-md">
                        <i class="fa-regular fa-pen-to-square"></i>
                      </a>
                      <a href="javascript:void(0);" class="btn btn-outline-danger btn-md"
                        onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteArticle.php?id=<?= $row['id'] ?>'; }">
                        <i class="fa-regular fa-trash-can"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            目前沒有文章
          <?php endif; ?>
          </div>
          <?php if (isset($_GET["p"])): ?>
            <nav aria-label="Page navigation example ">
              <ul class="pagination d-flex justify-content-end">
                <?php for ($i = 1; $i <= $total_page; $i++): ?>
                  <li class="page-item <?php if ($page == $i) echo "active"; ?>">
                    <a class="page-link" href="article-list.php?p=<?= $i ?>&order=<?= $order ?>">
                      <?= $i ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>
  </div>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>