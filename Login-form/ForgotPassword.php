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
    <form method="post" action="ForgotPassword.php" class="mainForm">
        <h1 class="formH1">Account Verification</h1>
        <input type="text" name="code" required placeholder="Code">
        <input type="submit" class="btn" value="Next">
    </form>
</div>
</body>
</html>
<?php
session_start();
if (isset($_COOKIE['login'])){
    $_SESSION['login'] = true;


}else{
    $_SESSION['login'] = false;
    unset($_SESSION["email"]);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["code"] == $_SESSION["code"]) {
        setcookie('login',true,time() + 5184000,'/','localhost',true,true);
        $_SESSION['login'] = true;
        $_SESSION["email"]=$_SESSION['g.email'];
        unset($_SESSION['g.email']);
        header("location:NewPassword.php");
    }else
        echo"<h3 class='error'>Code is wrong , Try again.</h3>";
}