<?php
session_start();

if (!isset($_POST["account"])) {
    header("Location: sign-in.php");
    exit;
}

require_once("../../db_connect.php");

$account = $_POST["account"];
$password = $_POST["password"];

//echo "$account, $password";
// $_SESSION["error"]["times"] = 0;

if (empty($account)) {
    // echo "請輸入帳號";
    $_SESSION["error"]["message"] = "請輸入帳號";
    header("location: sign-in.php");
    exit;
}
if (empty($password)) {
    // echo "請輸入密碼";
    $_SESSION["error"]["message"] = "請輸入密碼";
    header("location: sign-in.php");
    exit;
}

$password = md5($password);
// 加密

$sql = "SELECT * FROM users WHERE account='$account' AND password='$password'";
// echo $sql;
$result = $conn->query($sql);
$userCount = $result->num_rows;

if ($userCount != 0) {
    // echo "登入成功";
    unset($_SESSION["error"]);


    $user = $result->fetch_assoc();
    $_SESSION["user"] = [
        "account" => $user["account"],
        "name" => $user["name"],
        "gender" => $user["gender"],
        "birthday" => $user["birthday"],
        "email" => $user["email"],
        "phone" => $user["phone"],
        "address" => $user["address"],

    ];

    header("location:users.php");
    exit;
} else {
    // echo "帳號或密碼錯誤";

    if (!isset($_SESSION["error"]["times"])) {
        $_SESSION["error"]["times"] = 1;
    } else {
        $_SESSION["error"]["times"]++;
    }
    $errorTimes = $_SESSION["error"]["times"];
    $acceptErrorTimes = 5;
    $remainErrorTimes = $acceptErrorTimes - $errorTimes;

    $_SESSION["error"]["message"] = "帳號或密碼錯誤，還有$remainErrorTimes 次機會";


    header("location: sign-in.php");
    exit;
}

$conn->close();
