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
      <p class="m-0 d-inline text-lg text-secondary">文章管理 /<span class="text-sm">文章列表</span></p>
      <div>
        <!-- sort button -->
        <div class="btn-group btn-group-md">
          <button class="btn btn-outline-secondary">Share</button>
          <button class="btn btn-outline-secondary">Export</button>
          <button class="btn btn-outline-secondary">Export</button>
          <button class="btn btn-outline-secondary">Export</button>
        </div>
        <!-- add button -->
        <button class="btn btn-outline-secondary btn-md">
          <i class="fa-solid fa-plus"></i>新增
        </button>
      </div>
    </div>
    <hr>
    <!-- table-->
    <div class="table-responsive small">
      <table class="table table-striped table-bordered table-md">
        <thead>
          <tr>
            <th scope="d-flex col align-items-center">
              <span style="background-color: none;">編號</span>
              <button
                type="button"
                class="btn btn-outline-white btn-sm sort">
                <i class="fa-solid fa-sort-down"></i>
              </button>
            </th>
            <th scope="col">標籤</th>
            <th scope="col" class="col-2">標題</th>
            <th scope="col" class="col-2">內容</th>
            <th scope="col">圖片</th>
            <th scope="col">
              <span style="background-color: none;">發布時間</span>
              <button
                type="button"
                class="btn btn-outline-white btn-sm sort">
                <i class="fa-solid fa-sort-down"></i>
              </button>
            </th>
            <th scope="col" class="col-2">動作</th>
          </tr>
        </thead>
        <tbody>
          <tr class="align-middle">
            <td>1,001</td>
            <td>random</td>
            <td>data</td>
            <td>placeholder</td>
            <td>text</td>
            <td>text</td>
            <td class="d-flex gap-3 ">
              <a href="article-edit.php" class="btn btn-outline-secondary btn-md">
                <i class="fa-regular fa-eye"></i>
              </a>
              <a href="article-edit.php" class="btn btn-outline-secondary btn-md">
                <i class="fa-regular fa-pen-to-square"></i>
              </a>
              <a href="" class="btn btn-outline-secondary btn-md">
                <i class="fa-regular fa-trash-can"></i>
              </a>
            </td>
          </tr>
          <tr>
            <td>1,002</td>
            <td>placeholder</td>
            <td>irrelevant</td>
            <td>visual</td>
            <td>layout</td>
            <td>text</td>
            <td>text</td>

          </tr>


        </tbody>
      </table>
    </div>
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