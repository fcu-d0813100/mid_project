<?php
require_once("/xampp/htdocs/mid_project/db_connect.php");

// 獲取文章總數
$sqlAll = "SELECT * FROM article WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$articleCountAll = $resultAll->num_rows;


  $search = $_GET["search"];
  $sql = "SELECT * FROM article_type";
  $result = $conn->query($sql);
  $typeCount = $result->num_rows;

     
 

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
    <div class="d-flex justify-content-between align-items-start mt-3">

      <div>
        <p class="m-0 d-inline text-lg text-secondary">文章管理 /<span class="text-sm">文章類型</span></p>
      </div>
      <div class="d-flex justify-content-between gap-2">
        <?php if (isset($_GET["search"])): ?>
          <a href="article-type.php" class="btn btn-outline-secondary" title="回文章列表"><i class="fa-solid fa-left-long"></i></a>
        <?php endif; ?>
        <!-- sort search -->
        <form action="">
          <div class="input-group">
            <input type="search" class="form-control border border-dark" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?> " placeholder="搜尋標題">
            <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
        <div>

          <!-- add button -->
          <div class="text-end">
            <a href="article-create.php" class="btn btn-outline-secondary btn-md "><i class="fa-solid fa-plus"></i> 新增</a>
          </div>

        </div>
        
      </div>
    </div>
    <hr>
    <!-- table-->
    <div class="table-responsive large">

      <div class="d-flex justify-content-between">
        <?php if ($typeCount > 0):
          $rows = $result->fetch_all(MYSQLI_ASSOC) ?>
          共有<?= $typeCount ?> 個類型
          <!-- sort button -->

      </div>
      <table class="table table-striped table-md text-md">
        <thead>
          <tr>
            <th scope="col" class="col-1">編號</th>
            <th scope="col" class="col-1">類型</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($rows as $row) : ?>
            <tr class="align-middle datatype">
              <td><?= $row["id"] ?></td>
              <td><?= $row["name"] ?></td>
              
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
              <a class="page-link" href="article-type.php?p=<?= $i ?>&order=<?= $order ?>">
                <?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </main>


  </div>


  <script>
    function sortTable(orderType) {
      var page = <?= $page ?>;
      var url = "article-type.php?p=" + page + "&order=" + orderType;
      window.location.href = url;
    }
  </script>


  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>