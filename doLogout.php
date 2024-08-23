<!-- 登出的頁面讓他回到sign-in -->
<?php
session_start();

session_destroy();

unset($_SESSION["user"]);

header("location:sp/user/sign-in.php");


?>