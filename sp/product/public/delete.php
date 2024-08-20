<?php include('../config/database.php'); ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo "<p>Product deleted successfully!</p>";
    header("Location: index.php");
}
?>
