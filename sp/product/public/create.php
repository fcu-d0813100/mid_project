<?php 
include('../config/database.php'); 
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
  <link rel="stylesheet" href="../../css/style.default.premium.css" id="theme-stylesheet">
  <link rel="stylesheet" href="../css/style.css" id="theme-stylesheet">
  <!-- Custom stylesheet - for your changes-->
  <!-- <link rel="stylesheet" href="../css/custom.css"> -->
  <!-- font-awsome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <?php include("../../../nav1.php") ?>
  <main class="main-content-wrapper ">
    <header>
        <h1>新增產品</h1>
    </header>
    <div class="container">
        <form method="POST">
            <label for="id">ID:</label>
            <input type="number" id="id" name="id" required>

            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>

            <label for="brand_name">Brand Name:</label>
            <input type="text" id="brand_name" name="brand_name" required>

            <label for="main_category_name">Main Category:</label>
            <input type="text" id="main_category_name" name="main_category_name" required>

            <label for="sub_category_name">Sub Category:</label>
            <input type="text" id="sub_category_name" name="sub_category_name" required>

            <label for="color_id">Color ID:</label>
            <input type="number" id="color_id" name="color_id" required>

            <label for="color_name">Color Name:</label>
            <input type="text" id="color_name" name="color_name" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="images_id">Images ID:</label>
            <input type="number" id="images_id" name="images_id" required>

            <input type="submit" value="Create">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $product_name = $_POST['product_name'];
            $brand_name = $_POST['brand_name'];
            $main_category_name = $_POST['main_category_name'];
            $sub_category_name = $_POST['sub_category_name'];
            $color_id = $_POST['color_id'];
            $color_name = $_POST['color_name'];
            $price = $_POST['price'];
            $images_id = $_POST['images_id'];

            // 插入数据到数据库
            $sql = "INSERT INTO product_list (id, product_name, brand_id, main_category_id, sub_category_id, color_id, price, description, images_id)
                    VALUES (?, ?, 
                        (SELECT id FROM brand WHERE name = ?), 
                        (SELECT id FROM main_category WHERE name = ?), 
                        (SELECT id FROM sub_category WHERE name = ?), 
                        (SELECT id FROM color WHERE color = ?), ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id, $product_name, $brand_name, $main_category_name, $sub_category_name, $color_name, $color_id, $price, $images_id]);

            echo "<p>Product created successfully!</p>";
        }
        ?>
    </div>
    </main>


  </div>


  <script>
    function sortTable(orderType) {
      var page = <?= $page ?>;
      var url = "article-list.php?p=" + page + "&order=" + orderType;
      window.location.href = url;
    }
  </script>


  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</body>

</html>
