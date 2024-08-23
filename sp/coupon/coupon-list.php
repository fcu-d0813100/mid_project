<?php
// 使用mysql
require_once("../../db_connect.php");

$whereClause = "WHERE coupon_list.valid = 1 ";

$sqlpayAll = "SELECT * FROM coupon_list WHERE type_id = 1 AND valid = 1";
$resultype1All = $conn->query($sqlpayAll);
$type1CountAll = $resultype1All->num_rows;

$sqlpayAll = "SELECT * FROM coupon_list WHERE type_id = 2 AND valid = 1";
$resultype2All = $conn->query($sqlpayAll);
$type2CountAll = $resultype2All->num_rows;

$sqlsearchAll = "SELECT * FROM coupon_list WHERE name  LIKE '%$search%' AND valid = 1";
$resulsearcAll = $conn->query($sqlsearchAll);
$searcCountAll = $resulsearcAll->num_rows;

// 總數量查詢
$sqlAll = "SELECT * FROM coupon_list WHERE valid = 1";
$resulAll = $conn->query($sqlAll);
$couponCountAll = $resulAll->num_rows;

$page = isset($_GET["p"]) ? intval($_GET["p"]) : 1;
$per_page = 6;
$start_item = ($page - 1) * $per_page;
$total_Page = ceil($couponCountAll / $per_page);

if (isset($_GET["start_date"])) {
  $date = $_GET["start_date"];
  $whereClause .= "AND coupon_list.start_date = '$date'";
} elseif (isset($_GET["start"]) && isset($_GET["end"])) {
  $start = $_GET["start"];
  $end = $_GET["end"];
  $whereClause .= "AND coupon_list.start_date BETWEEN '$start' AND '$end'";
}

// 类型过滤
$type_id = isset($_GET["type_id"]) ? intval($_GET["type_id"]) : null;
if ($type_id) {
  $whereClause .= " AND coupon_list.type_id = $type_id";
}

// if (isset($_GET["type_id"]) && $_GET["type_id"] == 1) {
//   $whereClause .= " AND coupon_list.type_id = 1";
//   $total_Page = ceil($type1CountAll / $per_page);
// } elseif (isset($_GET["type_id"]) && $_GET["type_id"] == 2) {
//   $whereClause .= " AND coupon_list.type_id = 2";
//   $total_Page = ceil($type2CountAll / $per_page);
// }

// 搜索
// Sanitize search input
$search = isset($_GET["search"]) ? $conn->real_escape_string($_GET["search"]) : "";
if (!empty($search)) {
    $whereClause .= "AND coupon_list.name LIKE '%$search%'";
}
// if (isset($_GET["search"])) {
//   $search = $_GET["search"];
//   $whereClause .= "AND coupon_list.name LIKE '%$search%'";
// }

// $search = isset($_GET["search"]) ? $conn->real_escape_string($_GET["search"]) : "";
// if (!empty($search)) {
//   $whereClause .= " AND coupon_list.name LIKE '%$search%'";
// }

// if (isset($_GET["search"]) && !empty($_GET["search"])) {
//   $search = $conn->real_escape_string($_GET["search"]);
//   $whereClause .= " AND coupon_list.name LIKE '%$search%' ";
//   $sqlCount = "SELECT COUNT(*) as total FROM coupon_list $whereClause";
//   $stmtCount = $conn->prepare($sqlCount);
// }

$sql = "SELECT coupon_list.*, type.name AS type_name 
        FROM coupon_list 
        JOIN type ON coupon_list.type_id = type.id
        $whereClause
        ORDER BY coupon_list.start_date DESC
        LIMIT $start_item, $per_page";
$result = $conn->query($sql);

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>優惠券列表</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <?php include("./css.php") ?>
</head>

<body>
  <?php include("../../nav1.php") ?>
  <main class="main-content ">



    <div class="container">
      <div class="mt-5">
        <div class="d-flex justify-content-between align-items-start mt-3">
          <p class="m-0 d-inline  h2">優惠券管理 <span class="text-sm fs-5"> / 優惠券列表</span>
          </p>
        </div>
        <hr>
        <div class="text-end">
          <a class="btn btn-dark btn-md" href="coupon-create.php">
            <i class="fa-solid fa-plus">新增</i>
          </a>
        </div>

        <!-- 照狀態分類 -->
        <div class="col-12  text-end">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link  <?php if (!isset($_GET["type_id"])) echo "active" ?>" aria-current="page" href="coupon-list.php?p=1">全部 <?= $couponCountAll ?></a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php if (isset($_GET["type_id"]) && $_GET["type_id"] == 1) echo "active" ?> " href="coupon-list.php?p=1&type_id=1">百分比% <?= $type1CountAll  ?></a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php if (isset($_GET["type_id"]) && $_GET["type_id"] == 2) echo "active" ?> " href="coupon-list.php?p=1&type_id=2">金額 <?= $type2CountAll  ?></a>
            </li>
          </ul>
        </div>

        <!-- 關鍵字搜尋 -->
        <div class="select d-flex align-items-center justify-content-between border-start border-end bg-white ps-2">
          <form class="d-flex my-3 " method="GET">
            <div class="col-12 me-1">
              <div class="input-group ">
                <input type="search" class="form-control rounded-0" name="search" value="<?php echo isset($_GET["search"]) ? htmlspecialchars($_GET["search"]) : "" ?>" placeholder="優惠券名稱">
                <button class="btn btn-dark rounded-end" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
              </div>
            </div>
          </form>


          <!-- 日期篩選 -->
          <?php if (!isset($_GET["start_date"])): ?>
            <div class="mx-3 my-2 py-2 ">
              <form action="">
                <?php
                $today = date('Y-m-d');
                $start = isset($_GET["start"]) ? $_GET["start"] : $today;
                $end = isset($_GET["end"]) ? $_GET["end"] : $today;
                ?>
                <div class="row g-2">
                  <?php if (isset($_GET["start"])) : ?>
                    <div class="col-auto">
                      <a class="btn btn-dark" href="coupon-list.php?p=1"><i class="fa-solid fa-left-long"></i></a>
                    </div>
                  <?php endif; ?>
                  <div class="col-auto">
                    <input type="date" class="form-control" name="start" value="<?= $start ?>" id="start-date">
                  </div>
                  <div class="col-auto">
                    ~
                  </div>
                  <div class="col-auto me-3">
                    <input type="date" class="form-control" name="end" value="<?= $end ?>" id="end-date">
                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn btn-dark ">
                      <i class="fa-solid fa-filter"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          <?php endif; ?>
        </div>


        <!-- 優惠券列表 -->
        <?php if ($couponCountAll > 0) :
          $rows = $result->fetch_all(MYSQLI_ASSOC);
        ?>
          <!-- table-->
          <table class="table border text-center align-middle"> <!-- table-bordered -->
            <thead class="">
              <tr class="">
                <th></th>
                <th>活動名稱</th>
                <th>折扣代碼</th>
                <th>消費金額</th>
                <th>促銷期限</th>
                <th>折扣方式</th>
                <th>折扣額度</th>
                <th>已使用/限制</th>
                <th>狀態</th>
                <!-- <th>領取/使用紀錄</th> -->
                <th>編輯</th>
                <th>刪除</th>
              </tr>

            </thead>
            <tbody class="">
              <?php
              foreach ($rows as $row) : ?>
                <tr class="">
                  <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
                  <td><?= $row["name"] ?></td>
                  <td><?= $row["code"] ?></td>
                  <td><?= $row["minimum_amount"] ?></td>
                  <td><?= $row["start_date"] ?><br><?= $row["end_date"] ?></td>
                  <td><?= $row["type_name"] ?></td>
                  <td><?= $row["discount_value"] ?></td>
                  <td><?= $row["used"] ?>/<?= $row["maximum"] ?></td>

                  <!-- swith按鈕 -->
                  <td>
                    <div class="form-check form-switch">
                      <?php
                      // 根據開始和結束日期檢查是否在範圍內
                      $isActive = $today >= $row["start_date"] && $today <= $row["end_date"];
                      ?>
                      <input class="form-check-input " type="checkbox" role="switch" id="flexSwitchCheckDefault" <?= $isActive ? 'checked' : 'disabled' ?>>
                    </div>
                  </td>

                  <!-- 修改編輯 -->
                  <td>
                    <a href="coupon-edit.php?id=<?= $row["id"] ?>" class="btn btn-outline-danger btn-md">
                      <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                  </td>

                  <!-- 刪除警告 modal -->
                  <td>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= urlencode($row["id"]) ?> ">
                      <i class="fa-regular fa-trash-can"></i>
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content ">
                          <div class="modal-body">
                            <h1 class="modal-title py-3" id="exampleModalLabel">確定要刪除此筆資料 <i class="fa-solid fa-triangle-exclamation text-lg" style="color: #f50000;"></i></h1>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-dark" id="confirmDelete">確定</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <!-- 換頁page -->
          <nav aria-label="Page navigation example ">
            <ul class="pagination justify-content-center mt-5">
              <?php if (isset($_GET["p"]) && !isset($_GET["type_id"])): ?>
                <?php for ($i = 1; $i <= $total_Page; $i++) : ?>
                  <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link " href="coupon-list.php?p=<?= $i ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              <?php endif; ?>

              <?php if (isset($_GET["p"]) && isset($_GET["search"])): ?>
                <?php
                $searchPage = ceil($searcCountAll / $per_page);
                for ($i = 1; $i <= $searchPage; $i++): ?>
                  <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="coupon-list.php?p=<?= $i ?>&search=<?= $_GET["search"] ?>">
                      <?= $i?>
                    </a>
                  </li>
                <?php endfor; ?>
              <?php endif; ?>

              <?php if (isset($_GET["p"]) && isset($_GET["type_id"]) && $_GET["type_id"] == 1): ?>
                <?php $type1Page = ceil($type1CountAll / $per_page);
                for ($i = 1; $i <= $type1Page; $i++) : ?>
                  <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link " href="coupon-list.php?p=<?= $i ?>&type_id=1"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              <?php endif; ?>

              <?php if (isset($_GET["p"]) && isset($_GET["type_id"]) && $_GET["type_id"] == 2): ?>
                <?php $type2Page = ceil($type2CountAll / $per_page);
                for ($i = 1; $i <= $type2Page; $i++) : ?>
                  <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link " href="coupon-list.php?p=<?= $i ?>&type_id=2"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              <?php endif; ?>
            </ul>
          </nav>
        <?php else : ?>
          目前沒有優惠券
        <?php endif; ?>
      </div>

    </div>
  </main>


  </div>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/front.js"></script>
  <script>
    // function confirmDelete() {
    //   return confirm('您確定要刪除此優惠券嗎？');
    // }

    // 儲存刪除 URL 的變量
    let deleteUrl = '';

    // 當點擊觸發 Modal 的按鈕時，儲存刪除 URL
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
      button.addEventListener('click', function() {
        deleteUrl = 'doDeleteCoupon.php?id=' + encodeURIComponent(this.getAttribute('data-id'));
      });
    });

    // 當點擊“確定”按鈕時，執行刪除操作
    document.getElementById('confirmDelete').addEventListener('click', function() {
      if (deleteUrl) {
        window.location.href = deleteUrl;
      }
    });



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


    // 获取日期选择器
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');

    // 监听 start 日期的变化
    startDateInput.addEventListener('change', function() {
      const startDate = startDateInput.value;
      if (startDate) {
        // 设置 end 日期选择器的最小值为 start 日期
        endDateInput.min = startDate;
      }
    });

    // 初始设置 end 日期选择器的最小值为 start 日期
    endDateInput.min = startDateInput.value;
  </script>


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>