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
      <!-- sort search -->
      <form action="" class="col-6 search-form">
        <div class="input-group ">
          <input type="search" class="form-control border-dark searchInput" onkeyup="search()" placeholder="搜尋標題">
          <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-magnifying-glass pe-2"></i></button>
        </div>
      </form>

      <div>
        <!-- sort button -->
        <div class="btn-group btn-group-md">
          <button class="btn btn-outline-secondary">按時間排序 <i class="fa-solid fa-arrow-down"></i></button>
          <button class="btn btn-outline-secondary">按標籤排序 <i class="fa-solid fa-arrow-down"></i></button>
        </div>
        <!-- add button -->
        <button class="btn btn-outline-secondary btn-md">
          <i class="fa-solid fa-plus"></i> 新增
        </button>
      </div>
    </div>
    <hr>
    <!-- table-->
    <div class="table-responsive small">
      <table class="table table-striped table-md text-lg">
        <thead>
          <tr>
            <th scope="col" class="col-2">編號 <i class="fa-solid fa-sort btn btn-md mb-1"></th>
            <th scope="col">標籤</th>
            <th scope="col" class="col-1">標題</th>
            <th scope="col" class="col-2">內容</th>
            <th scope="col" >圖片</th>
            <th scope="col" class="col-3">發布時間 <i class="fa-solid fa-sort btn btn-md mb-1"></i></th>
            <th scope="col" class="col-1">動作</th>
          </tr>
        </thead>
        <tbody>
          <tr class="align-middle dataList" >
            <td>1,001</td>
            <td>random</td>
            <td>data</td>
            <td>text</td>
            <td class="ratio ratio-4x3"><img class="object-fit-cover img-fluid" src="/images/batman.webp" alt=""></td>

            <td>text</td>
            <td class="d-flex gap-3">
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
          <tr  class="align-middle dataList">
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
  
  <script>
  function search() {
    let searchInput = document.querySelector(".searchInput");
    let filter = searchInput.value.toUpperCase();
    let tr = document.querySelectorAll(".dataList");
    
    tr.forEach(row => {
      let td = row.getElementsByTagName('td');
      let match = false;

      for (let i = 0; i < td.length; i++) {
        let txtValue = td[i].textContent || td[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          match = true;
          break;
        }
      }
      row.style.display = match ? "" : "none";
    });
  }
</script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>