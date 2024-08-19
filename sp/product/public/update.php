<?php include('../config/database.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>商品更新</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>商品更新</h1>
    </header>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM product_list WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $productname = $_POST['name'];
            $mainid = $_POST['main_category_id'];
            $subid = $_POST['sub_category_id'];
            $colorid = $_POST['color_id'];  // 修正拼寫錯誤
            $price = $_POST['price'];

            $sql = "UPDATE product_list SET product_name = ?, main_category_id = ?, sub_category_id = ?, color_id = ?, price = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$productname, $mainid, $subid, $colorid, $price, $id]);

            echo "<p>Product updated successfully!</p>";
        }
        ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $product['product_name']; ?>" required>

            <label for="main_category_id">Main Category ID:</label>
            <input type="number" id="main_category_id" name="main_category_id" value="<?php echo $product['main_category_id']; ?>" required>

            <label for="sub_category_id">Sub Category ID:</label>
            <input type="number" id="sub_category_id" name="sub_category_id" value="<?php echo $product['sub_category_id']; ?>" required>

            <label for="color_id">Color ID:</label>
            <input type="number" id="color_id" name="color_id" value="<?php echo $product['color_id']; ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" step="0.01" required>

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
