<?php
// 使用mysql
require_once("../../db_connect.php");

$sql = "SELECT * FROM coupon_list 
WHERE valid=1";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bootstrap Dashboard</title>
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
      <p class="m-0 d-inline text-lg text-secondary">優惠券管理 /<span class="text-sm">優惠券列表</span></p>
      <div>

        <!-- add button -->
        <a class="btn btn-outline-secondary btn-md" href="coupon-create.php">
          <i class="fa-solid fa-plus">新增</i>
        </a>
      </div>
    </div>

    <!-- 照狀態分類 -->
    <div class="col-12 mt-3">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="coupon-list.php">全部 </a>
        </li>
      </ul>
    </div>


    <!-- table-->
    <table class="table border text-center"> <!-- table-bordered -->
      <thead>

        <tr>
          <th></th>
          <th>活動名稱</th>
          <th>折扣代碼</th>
          <th>促銷期限</th>
          <th>折扣方式</th>
          <th>使用次數</th>
          <th>狀態</th>
          <th>領取/使用紀錄</th>
          <th>編輯</th>
          <th>刪除</th>
        </tr>

      </thead>
      <tbody>
        <?php foreach ($rows as $row) : ?>

          <tr>
            <td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
            <td><?= $row["name"] ?></td>
            <td><?= $row["code"] ?></td>
            <td><?= $row["start_date"] ?>~<?= $row["end_date"] ?></td>
            <td><?= $row["status_id"] ?></td>
            <td><?= $row["maximum"] ?></td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"><!-- 鎖死disabled -->
              </div>
            </td>

            <td class=" ">
              <a href="coupon.php" class="btn btn-outline-secondary btn-md">
                <i class="fa-regular fa-eye"></i>
              </a>
            </td>
            <td>
              <a href="coupon-edit.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary btn-md">
                <i class="fa-regular fa-pen-to-square"></i>
              </a>
            </td>
            <td>
              <a href="doDeleteCoupon.php?id=<?= $row["id"] ?>" class="btn btn-outline-secondary ">
                <i class="fa-regular fa-trash-can"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>





  </main>


  </div>
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


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>