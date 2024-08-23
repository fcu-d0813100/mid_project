<!-- 登出的頁面讓他回到sign-in -->
<?php
session_start();

unset($_SESSION["user"]);

header("location: sign-in.php");

?>

