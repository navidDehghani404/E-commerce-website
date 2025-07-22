<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود</title>
    <link rel="stylesheet" href="Logs-css/Login.css">
</head>
<body>
<div class="mainDiv">
    <form method="post" action="Login.php" class="mainForm">
        <h1 class="formH1">Login Page</h1>
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <a href="ForgotPasswordEmail.php" style="text-align: center">Forgot Password?</a>
        <a href="../signup-form/signup.php" style="text-align: center;margin-top: 1%">Do you have account? Sign up</a>
        <input type="submit" class="btn" value="Login">
    </form>
</div>
</body>
</html>
<!--ultity-->
<?php
require_once "../utility_class/connect.php";
require_once "../models/User.php";
session_start();
if (isset($_COOKIE['login'])){
    $_SESSION['login'] = true;

    if (!empty($_POST["email"]))
        $_SESSION["email"]=$_POST["email"];

}else{
    $_SESSION['login'] = false;
    unset($_SESSION["email"]);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connect=new  Connect();
    $user = new \models\User($connect->connectToDatabase());
    $user->isAdmin($_POST["email"], $_POST["password"],'../AdminPanel/AdminPanel.php');
    $user->login($_POST["email"], $_POST["password"]);
    if (strlen($_POST["password"]) < 8) {
        echo "<p class='error'>Password must be at least 8 characters long.</p><br>";
        exit();
    }
}