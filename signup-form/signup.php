<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
<div class="mainDiv">
    <form method="post" action="signup.php" class="mainForm">
        <h1 class="formH1">Sign Up Page</h1>
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <a href="../Login-form/Login.php" style="text-align: center">Do you have account? Login</a>
        <input type="submit" class="btn" value="Sign Up">
    </form>
</div>
</body>
</html>

<?php

use utility_class\Mailer;

require_once "../utility_class/connect.php";
require_once "../models/User.php";
require '../utility_class/Mailer.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (strlen($_POST["password"]) < 8) {
        echo "<p class='error'>Password must be at least 8 characters long.</p><br>";
        exit();
    }
    try {
        $connect= new  Connect();
        $user= new \models\User($connect->connectToDatabase());
        $user->signedUp($_POST["email"]);
        } catch (PDOException $e){
        echo "<p class='error'>Not connect.</p><br>";
    }
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["password"] = $_POST["password"];
    $mailedCode=rand(100000,999999);
    $_SESSION["code"]=$mailedCode;
    $mail=new Mailer();
    $mail->sender($_POST["email"],$mailedCode);
    header('Location: Verification.php');
}
