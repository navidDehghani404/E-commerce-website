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
session_start();
use mailer\Mailer;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../classes/Mailer.php';
    if (strlen($_POST["password"]) < 8) {
        echo "<p class='error'>Password must be at least 8 characters long.</p><br>";
        exit();
    }
    try {
        $pdo= new PDO("mysql:host=localhost;dbname=webstore", "root", "");
        $query=$pdo->prepare('SELECT * FROM user WHERE email=:email');
        $query->bindParam(':email',$_POST["email"],PDO::PARAM_STR);
        $query->execute();
        $result=$query->fetch();
        if ($result){
            echo "<p class='error'>Email already exists.</p><br>";
            exit();
        }
    }catch (PDOException $e){
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
