<?php


if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $sql = "SELECT * FROM article WHERE title LIKE '%$search%'";
} else {
  $sql = "SELECT 
    article.*,  
    brand.name AS brand_name,
    article_type.name AS type_name
    FROM  article
    JOIN brand ON article.brand_id = brand.id
    JOIN  article_type ON article.type_id = article_type.id";
}
require_once("/xampp/htdocs/mid_project/db_connect.php");


$result = $conn->query($sql);
$articleCount = $result->num_rows;
// $rows = $result->fetch_all(MYSQLI_ASSOC);

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
        <p class="m-0 d-inline text-lg text-secondary">文章管理 /<span class="text-sm">文章列表</span></p>
      </div>
      <div class="d-flex justify-content-between gap-2">
        <?php if (isset($_GET["search"])): ?>
          <a href="article-list.php" class="btn btn-outline-secondary" title="回文章列表"><i class="fa-solid fa-left-long"></i></a>
        <?php endif; ?>
        <!-- sort search -->
        <form action="">
          <div class="input-group">
            <input type="search" class="form-control border border-dark" name="search" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?> " placeholder="搜尋標題">
            <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
        <div>
          <!-- sort button -->
          <!-- <div class="btn-group btn-group-md">
          <button class="btn btn-outline-secondary">按時間排序 <i class="fa-solid fa-arrow-down"></i></button>
          <button class="btn btn-outline-secondary">按標籤排序 <i class="fa-solid fa-arrow-down"></i></button>
        </div> -->
          <!-- add button -->
          <div class="text-end">
            <a href="article-create.php" class="btn btn-outline-secondary btn-md "><i class="fa-solid fa-plus"></i> 新增</a>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <!-- table-->
    <div class="table-responsive small">
      <?php if ($articleCount > 0):
        $rows = $result->fetch_all(MYSQLI_ASSOC) ?>
        共有<?= $articleCount ?> 則文章
        <table class="table table-striped table-md text-md">
          <thead>
            <tr>
              <th scope="col" class="col-1">編號 <i class="fa-solid fa-sort btn btn-sm mb-1"></th>
              <th scope="col" class="col-1">品牌</th>
              <th scope="col" class="col-1">類型</th>
              <th scope="col" class="col-3">標題</th>
              <th scope="col">圖片</th>
              <th scope="col" class="col-2">發布時間 <i class="fa-solid fa-sort btn btn-sm mb-1"></i></th>
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

                <td class="ratio ratio-4x3"><img class="object-fit-cover img-fluid" src="/images/batman.webp" alt=""></td>

                <td><?= $row["launched_date"] ?></td>
                <td class="gap-3">
                  <a href="article-review.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary btn-md">
                    <i class="fa-regular fa-eye"></i>
                  </a>
                  <a href="article-edit.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary btn-md">
                    <i class="fa-regular fa-pen-to-square"></i>
                  </a>
                  <a href="doDeleteArticle.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary btn-md">
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
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>


  </main>


  </div>
  <script>
    //分頁
    const rowsPerPage = 4; // 每頁幾篇文章
    const rows = <?= json_encode($rows) ?>; // PHP 傳到给 JS
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    let currentPage = 1;

    function displayPage(page) {
      const start = (page - 1) * rowsPerPage;
      const end = start + rowsPerPage;
      const paginatedItems = rows.slice(start, end);
      1

      const tbody = document.querySelector("tbody");
      tbody.innerHTML = ""; // 清空现有行

      paginatedItems.forEach(row => {
        const tr = document.createElement("tr");
        tr.classList.add("align-middle", "dataList");
        tr.innerHTML = `
        <td>${row.id}</td>
        <td>${row.brand_name}</td>
        <td>${row.type_name}</td>
        <td class="article-title">${row.title}</td>
        <td class="ratio ratio-4x3"><img class="object-fit-cover img-fluid" src="/images/batman.webp" alt=""></td>
        <td>${row.launched_date}</td>
        <td class="gap-3">
          <a href="article-review.php?id=${row.id}" class="btn btn-outline-secondary btn-md"><i class="fa-regular fa-eye"></i></a>
          <a href="article-edit.php?id=${row.id}" class="btn btn-outline-secondary btn-md"><i class="fa-regular fa-pen-to-square"></i></a>
          <a href="doDeleteArticle.php?id=${row.id}" class="btn btn-outline-secondary btn-md"><i class="fa-regular fa-trash-can"></i></a>
        </td>
      `;
        tbody.appendChild(tr);
      });

      renderPagination();
    }

    function renderPagination() {
      const pagination = document.getElementById("pagination");
      pagination.innerHTML = ""; // 清空现有分页

      for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.classList.add("page-item");
        li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
        pagination.appendChild(li);
      }
    }

    function changePage(page) {
      currentPage = page;
      displayPage(currentPage);
    }

    // 初始化显示第一页
    displayPage(currentPage);
  </script>
  <script src="../js/search.js"></script>
  <script src="../js/pagination.js"></script>
</body>

</html>