<?php

require_once("../../db_connect.php");
//計算資料庫中全部的活動
$sqlAll = "SELECT * FROM active WHERE valid=1";
$resultALL = $conn->query($sqlAll);
$activeCountAll = $resultALL->num_rows;

$now = date('Y-m-d H:i:s');
$searchCount = 0;
$page = 1; //頁數
$startItem = 0;
$per_page = 5; //此頁要顯示幾筆活動
$totalPage = ceil($activeCountAll / $per_page);

if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $sql = "SELECT * FROM active 
          WHERE (brand LIKE '%$search%' 
          OR name LIKE '%$search%' 
          OR id LIKE '%$search%'
          OR start_at LIKE '%$search%') 
          AND valid = 1";
  $result = $conn->query($sql);
  $searchCount = $result->num_rows;
} elseif (isset($_GET["p"]) && isset($_GET["order"])) {
  $order = $_GET["order"];
  $page = $_GET["p"];
  $startItem = ($page - 1) * $per_page;
  switch ($order) {
    case 1:
      $where_clause = " ORDER BY id ASC";
      break;
    case 2:
      $where_clause = " ORDER BY id DESC";
      break;
    case 3:
      $where_clause = " ORDER BY start_at ASC";
      break;
    case 4:
      $where_clause = " ORDER BY start_at DESC";
      break;
  }
  //$sql = "SELECT * FROM active WHERE valid = 1 LIMIT $startItem,$per_page";
  $sql = "SELECT * FROM active WHERE valid = 1 $where_clause LIMIT $startItem, $per_page";
} else {

  header("location:active.php?p=1&order=1");
  exit;
  //$sql = "SELECT * FROM users WHERE valid = 1 LIMIT $startItem,$per_page";
}
$result = $conn->query($sql);
$userCount = $result->num_rows;
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
  <?php include("./css.php") ?>
  <style>
    .main-content {
      padding-left: 200px;
      padding-right: 0;
    }
  </style>
</head>

<body>
  <?php include("../../nav1.php") ?>

  <main class="main-content">
    <div class="container">
      <div class="d-flex justify-content-between align-items-start mt-5 align-middle">
        <p class="m-0 d-inline text-lg text-secondary"><a href="active.php" class="text-decoration-none text-dark h2">活動管理 </a> <span class="text-sm fs-5 text-dark"> / 活動列表</span></p>


        <form action="" class="align-self-center " style="width: 600px;">
          <div class="input-group mb-3">
            <input type="search" class="form-control border border-secondary" placeholder="輸入使用者名稱" aria-label="Recipient's username" aria-describedby="button-addon2" name="search"
              value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>">
            <button class="btn btn-dark border-start-0" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>



        <div>

          <a href="active-create.php" class="btn btn-dark btn-md "><i class="fa-solid fa-plus"></i> 新增</a>

        </div>
      </div>


      <!-- table-->
      <?php if ($searchCount):
        $rows = $result->fetch_all(MYSQLI_ASSOC); ?>
        <div class="text-md mb-2">共有<?= $searchCount;
                                    //var_dump($where_clause); 
                                    ?> 筆活動</div>

        <div class="table-responsive large">
          <table class="table table-striped table-md text-center" id="datatable">
            <thead>
              <tr class="align-middle">
                <th class="col" style="width: 105px;">

                  <?php if (isset($_GET["p"])) : ?>
                    <div class="d-flex">
  <span style="background-color: none;">ID</span>
  <div class="btn-group ms-2">
    <a 
      type="button"
      class="btn btn-outline-none btn-bordered-none btn-sm p-0 <?php echo $order == 2 ? 'active' : ''; ?>" 
      id="sortUpButton"
      href="active.php?p=<?php echo $page; ?>&order=2"
      onclick="toggleButton('sortUpButton', 'sortDownButton')">
      <i class="fa-solid fa-sort-up"></i>
    </a>
    <a 
      type="button"
      class="btn btn-outline-none btn-bordered-none btn-sm p-0 <?php echo $order == 1 ? 'active' : ''; ?>" 
      id="sortDownButton"
      href="active.php?p=<?php echo $page; ?>&order=1"
      onclick="toggleButton('sortDownButton', 'sortUpButton')">
      <i class="fa-solid fa-sort-down align-top"></i>
    </a>
  </div>
</div>

                  <?php
                  endif; ?>
                </th>
                <th class="col-2">圖片</th>
                <th class="col-1">活動品牌</th>
                <th class=" col" class="col-2">活動名稱</th>
                <th class="col" class="col-2" style=" width:150px;">
                  <span style="background-color: none;">活動日期</span>
                  <?php if (isset($_GET["p"])) : ?>
                    <a
                      type="button"
                      class="btn btn-outline-none btn-sm"
                      <?php if ($order == 3) echo "active" ?>
                      href="active.php?p=<?php echo $page; ?>&order=3">
                      <i class="fa-solid fa-sort-down"></i>
                    </a>

                    <a
                      type="button"
                      class="btn btn-outline-none btn-sm"
                      <?php if ($order == 4) echo "active" ?>
                      href="active.php?p=<?php echo $page; ?>&order=4">
                      <i class="fa-solid fa-sort-up"></i>
                    </a>
                  <?php
                  endif; ?>
                </th>
                <th class="col" style="width: 100px
            ;">活動地點</th>
                <th class="col-1">活動狀態</th>
                <th class="col" style="width: 100px;">報名人數</th>

                <th class="col-2">操作</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($rows as $row): ?>


                <tr class="align-middle">
                  <td><?= $row["id"] ?></td>
                  <td class="ratio ratio-4x3 activePic"><img class="object-fit-cover p-3" src="images/<?= $row["image"] ?>" alt=""></td>
                  <td><?= $row["brand"] ?></td>
                  <td><?= $row["name"] ?></td>
                  <td><?= $row["start_at"] ?></td>
                  <td>
                    <?= $row["address"] ?>
                  </td>
                  <td>
                    <?php
                    // 计算7天前的时间
                    $startAt = $row["start_at"];
                    // 将字符串转换为 DateTime 对象
                    $applyTime = new DateTime($startAt);
                    // 使用 modify 减去7天
                    $applyTime->modify('-7 days');
                    // 将 $applyTime 格式化为字符串
                    $applyTimeFor = $applyTime->format('Y-m-d H:i:s');
                    ?>
                    <?php if ($row["currentAPP"] === $row["maxAPP"]): ?>
                      <span class=" rounded-pill p-1 px-2 my-1 text-white" style="background-color: orange;">已額滿</span>
                    <?php endif; ?>
                    <?php if ($now < $applyTimeFor) : ?>
                      <span class=" rounded-pill bg-success p-1 px-2 my-1 text-white">報名中</span>
                    <?php elseif ($now < $row["start_at"] && $now > $applyTimeFor) : ?>
                      <span class=" rounded-pill bg-secondary p-1 px-2 my-1 text-white">已截止</span>
                    <?php elseif ($now > $row["start_at"] && $now < $row["end_at"]) : ?>
                      <span class=" rounded-pill bg-warning p-1 px-2 my-1 text-white">進行中</span>
                    <?php else : ?>
                      <span class=" rounded-pill bg-danger p-1 px-2 my-1 text-white">已結束</span>
                    <?php endif; ?>

                  </td>


                  <td><?= $row["currentAPP"] ?>/<?= $row["maxAPP"] ?></td>

                  <td>
                    <a href="active-info.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger">
                      <i class="fa-regular fa-eye"></i>
                    </a>
                    <a href="active-edit.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger">
                      <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger"
                      onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteActive.php?id=<?= $row['id'] ?>'; }">
                      <i class="fa-regular fa-trash-can"></i>
                    </a>

                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php if (!isset($_GET["search"])): ?>
          <nav aria-label="Page navigation example ">
            <ul class="pagination justify-content-center">
              <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?php if ($page == $i) echo "active"; ?>">
                  <a class="page-link " href="active.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>

        <?php endif; ?>

      <?php elseif ($activeCountAll && !isset($_GET["search"])):
        $rows = $result->fetch_all(MYSQLI_ASSOC); ?>
        <div class="text-md mb-2">共有<?= $activeCountAll;
                                    //var_dump($where_clause); 
                                    ?> 筆活動</div>
        <div class="table-responsive large">
          <table class="table table-striped table-md text-center" id="datatable">
            <thead>
              <tr class="align-middle">
                <th class="col" style="width: 105px;">

                  <?php if (isset($_GET["p"])) : ?>
                    <div class="d-flex">
                      <span style="background-color: none;">ID</span>
                      <div class=" btn-group ms-2 ">
                        <a
                          type="button"
                          class="btn btn-outline-none btn-bordered-none btn-sm p-0 "
                          <?php if ($order == 2) echo "active" ?>
                          href="active.php?p=<?php echo $page; ?>&order=2">
                          <i class="fa-solid fa-sort-up"></i>
                        </a>
                        <a
                          type="button"
                          class="btn btn-outline-none btn-bordered-none btn-sm p-0 "
                          <?php if ($order == 1) echo "active" ?>
                          href="active.php?p=<?php echo $page; ?>&order=1">
                          <i class="fa-solid fa-sort-down align-top"></i>
                        </a>
                      </div>
                    </div>
                  <?php
                  endif; ?>
                </th>
                <th class="col-2">圖片</th>
                <th class="col-1">活動品牌</th>
                <th class=" col" class="col-2">活動名稱</th>
                <th class="col" class="col-2" style=" width:150px;">
                 
                  <?php if (isset($_GET["p"])) : ?>
                    <div class="d-flex">
                    <span style="background-color: none;">活動日期</span>
                      <div class=" btn-group ms-2 ">
                        <a
                          type="button"
                          class="btn btn-outline-none btn-bordered-none btn-sm p-0 "
                          <?php if ($order == 2) echo "active" ?>
                          href="active.php?p=<?php echo $page; ?>&order=2">
                          <i class="fa-solid fa-sort-up"></i>
                        </a>
                        <a
                          type="button"
                          class="btn btn-outline-none btn-bordered-none btn-sm p-0 "
                          <?php if ($order == 1) echo "active" ?>
                          href="active.php?p=<?php echo $page; ?>&order=1">
                          <i class="fa-solid fa-sort-down align-top"></i>
                        </a>
                      </div>
                    </div>
                  <?php
                  endif; ?>
                </th>
                <th class="col" style="width: 100px
            ;">活動地點</th>
                <th class="col-1">活動狀態</th>
                <th class="col" style="width: 100px;">報名人數</th>

                <th class="col-2">操作</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($rows as $row): ?>


                <tr class="align-middle">
                  <td><?= $row["id"] ?></td>
                  <td class="ratio ratio-4x3 activePic"><img class="object-fit-cover p-3" src="images/<?= $row["image"] ?>" alt=""></td>
                  <td><?= $row["brand"] ?></td>
                  <td><?= $row["name"] ?></td>
                  <td><?= $row["start_at"] ?></td>
                  <td>
                    <?= $row["address"] ?>
                  </td>
                  <td>
                    <?php
                    // 计算7天前的时间
                    $startAt = $row["start_at"];
                    // 将字符串转换为 DateTime 对象
                    $applyTime = new DateTime($startAt);
                    // 使用 modify 减去7天
                    $applyTime->modify('-7 days');
                    // 将 $applyTime 格式化为字符串
                    $applyTimeFor = $applyTime->format('Y-m-d H:i:s');
                    ?>
                    <?php if ($row["currentAPP"] === $row["maxAPP"]): ?>
                      <span class=" rounded-pill p-1 px-2 my-1 text-white" style="background-color: orange;">已額滿</span>
                    <?php endif; ?>
                    <?php if ($now < $applyTimeFor) : ?>
                      <span class=" rounded-pill bg-success p-1 px-2 my-1 text-white">報名中</span>
                    <?php elseif ($now < $row["start_at"] && $now > $applyTimeFor) : ?>
                      <span class=" rounded-pill bg-secondary p-1 px-2 my-1 text-white">已截止</span>
                    <?php elseif ($now > $row["start_at"] && $now < $row["end_at"]) : ?>
                      <span class=" rounded-pill bg-warning p-1 px-2 my-1 text-white">進行中</span>
                    <?php else : ?>
                      <span class=" rounded-pill bg-danger p-1 px-2 my-1 text-white">已結束</span>
                    <?php endif; ?>

                  </td>


                  <td><?= $row["currentAPP"] ?>/<?= $row["maxAPP"] ?></td>

                  <td>
                    <a href="active-info.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger">
                      <i class="fa-regular fa-eye"></i>
                    </a>
                    <a href="active-edit.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger">
                      <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger"
                      onclick="if (confirm('確定要刪除嗎')) { window.location.href='doDeleteActive.php?id=<?= $row['id'] ?>'; }">
                      <i class="fa-regular fa-trash-can"></i>
                    </a>

                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <nav aria-label="Page navigation example ">
          <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPage; $i++): ?>
              <li class="page-item <?php if ($page == $i) echo "active"; ?>">
                <a class="page-link " href="active.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php else: ?>
        目前沒有任何活動
      <?php endif; ?>
    </div>
  </main>

  </div>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <scrip src="../js/front.js"></script> -->
<script>
  function toggleButton(activeId, inactiveId) {
  // 取得兩個按鈕的元素
  var activeButton = document.getElementById(activeId);
  var inactiveButton = document.getElementById(inactiveId);

  // 切換 active class
  activeButton.classList.add('active');
  inactiveButton.classList.remove('active');
}

</script>


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>