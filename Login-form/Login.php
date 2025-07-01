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

<?php
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
    if ($_POST["email"] == "admin@gmail.com" && $_POST["password"] == "admin1234") {
        header("Location: ../AdminPanel/AdminPanel.php");
        exit();
    }
    if (strlen($_POST["password"]) < 8) {
        echo "<p class='error'>Password must be at least 8 characters long.</p><br>";
        exit();
    }
    $pdo= new PDO("mysql:host=localhost;dbname=webstore", "root", "");
    $query=$pdo->prepare('SELECT * FROM user WHERE email=:email');
    $query->bindParam(':email',$_POST["email"],PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch();
    if (!$result){
        echo "<p class='error'>There is no email.</p><br>";
        exit();
    }else{
        $password=$result["password"];
        if (password_verify($_POST["password"],$password)) {
            setcookie('login',true,time() + 51184000,'/','localhost',true,true);
            $_SESSION['login'] = true;
            $_SESSION["email"]=$_POST["email"];

            header("Location:../UserPanel/AllProductPanel.php");
        }
        else{
            echo "<p class='error'>Wrong password.</p><br>";
        }
    }
}