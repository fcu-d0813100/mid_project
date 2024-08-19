<?php

require_once("../../db_connect.php");
//計算資料庫中全部的活動
$sqlAll = "SELECT * FROM active WHERE valid=1";
$resultALL = $conn->query($sqlAll);
$activeCountAll = $resultALL->num_rows;

$sql = "SELECT * FROM active";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);


$page = 1; //頁數
$per_page = 5; //此頁要顯示幾筆活動
$totalPage = ceil($activeCountAll / $per_page);

if (isset($_GET["p"])) {
  $page = $_GET["p"];
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>活動管理</title>
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
      <p class="m-0 d-inline text-lg text-secondary">活動管理 /<span class="text-sm">活動列表</span></p>
      <div class="align-self-center">
        <label for=""><i class="fa-solid fa-magnifying-glass"></i></label>
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search" style="width:600px;">
      </div>

      <div>
        <button class="btn btn-outline-secondary btn-lg">
          <a href="active-create.php" class="text-secondary addbtn"><i class="fa-solid fa-plus">新增</i></a>
        </button>
      </div>
    </div>


    <!-- table-->
    <?php if ($activeCountAll): ?>
      <div class="text-md">共有<?= $activeCountAll ?> 筆活動</div>

      <div class="table-responsive large">
        <table class="table table-striped table-md" id="datatable">
          <thead>
            <tr>
              <th scope="col" style="width: 100px;">
                <span style="background-color: none;">ID</span>
                <button
                  type="button"
                  class="btn btn-outline-none btn-sm sort">
                  <i class="fa-solid fa-sort-down"></i>
                </button>
              </th>
              <th scope="col">圖片</th>
              <th scope="col">活動品牌</th>
              <th scope="col" class="col-2">活動名稱</th>
              <th scope="col" class="col-2" style=" width:150px;"><span style="background-color: none;">活動日期</span>
                <button
                  type="button"
                  class="btn btn-outline-none btn-sm sort">
                  <i class="fa-solid fa-sort-down"></i>
                </button>
              </th>
              <th scope="col" style="width: 100px
            ;">活動地點</th>
              <th scope="col">活動狀態</th>
              <th scope="col" style="width: 100px;">報名人數</th>

              <th scope="col" class="col-2">操作</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row): ?>


              <tr class="align-middle">
                <td><?= $row["id"] ?></td>
                <td class="ratio ratio-4x3 activePic"><img class="object-fit-cover " src="images/<?= $row["image"] ?>" alt=""></td>
                <td><?= $row["brand"] ?></td>
                <td><?= $row["name"] ?></td>
                <td><?= $row["start_at"] ?></td>
                <td>
                  <?= $row["address"] ?>
                </td>
                <td>
                  <span class=" rounded-pill bg-success p-2 text-white">報名中</span>
                  <span class=" rounded-pill bg-danger p-2 text-white">已截止</span>
                  <span class=" rounded-pill bg-warning p-2 text-white">進行中</span>
                  <span class=" rounded-pill bg-secondary p-2 text-white">已結束</span>
                </td>

                <td><?= $row["currentAPP"] ?>/<?= $row["maxAPP"] ?></td>
                <td>
                  <a href="active-info.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary btn-lg">
                    <i class="fa-regular fa-eye"></i>
                  </a>
                  <a href="active-edit.php" class="btn btn-outline-secondary btn-lg">
                    <i class="fa-regular fa-pen-to-square"></i>
                  </a>
                  <a href="doDeleteActive.php" class="btn btn-outline-secondary btn-lg">
                    <i class="fa-regular fa-trash-can"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <nav aria-label="Page navigation example ">
        <ul class="pagination pagination-sm justify-content-center">
          <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <li class="page-item   <?php if ($page == $i) echo "active"; ?>">
              <a class="page-link " href="active.php?p=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php else: ?>
      目前沒有任何活動
    <?php endif; ?>
  </main>

  </div>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="../js/front.js"></script> -->
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



    function searchTable() {
      // 获取输入框中的搜索关键字

      const input = document.getElementById('searchInput');
      const filter = input.value.toLowerCase();
      const table = document.getElementById('datatable');
      const tr = table.getElementsByTagName('tr');

      console.log(tr);

      // 循环遍历所有表格行
      for (let i = 1; i < tr.length; i++) { // 跳过表头
        const tds = tr[i].getElementsByTagName('td');
        let match = false;

        // 循环遍历当前行中的每个单元格
        for (let j = 0; j < tds.length; j++) {
          const td = tds[j];
          if (td) {
            // 如果单元格内容包含搜索关键字，则标记为匹配
            if (td.textContent.toLowerCase().indexOf(filter) > -1) {
              match = true;
              break;
            }
          }
        }

        // 如果匹配，显示该行；否则隐藏
        tr[i].style.display = match ? '' : 'none';
      }
    }
  </script>


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>