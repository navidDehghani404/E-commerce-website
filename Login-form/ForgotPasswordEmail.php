<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود</title>
    <link rel="stylesheet" href="Logs-css/ForgotPassword.css">
</head>
<body>
<div class="mainDiv">
    <form method="post" action="ForgotPasswordEmail.php" class="mainForm">
        <h1 class="formH1">Email Verification</h1>
        <input type="text" name="email" required placeholder="Email">
        <input type="submit" class="btn" value="Next">
    </form>
</div>
</body>
</html>
<?php
require '../utility_class/Select.php';
require '../utility_class/Mailer.php';
use select\Select;
use utility_class\Mailer;
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $select = new Select();
    $pdo = new PDO("mysql:host=localhost;dbname=webstore", "root", "");
    $result=$select->fetch($pdo,'user','email',$_POST['email']);
    if ($result){
        $_SESSION['code'] = rand(100000,999999);
        $_SESSION['g.email'] = $_POST['email'];
        $mailer = new Mailer();
        $mailer->sender($_POST['email'],$_SESSION['code']);
        header('location:ForgotPassword.php');
    }else{
        exit('<h3 class="error">There is no email.</h3>');
    }
}