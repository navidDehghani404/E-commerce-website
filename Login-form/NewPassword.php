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
    <form method="post" action="NewPassword.php" class="mainForm">
        <h1 class="formH1">New Password</h1>
        <input type="password" name="pass" required placeholder="Password">
        <input type="password" name="passhint" required placeholder="Password Hint">
        <input type="submit" class="btn" value="Finish">
    </form>
</div>
</body>
</html>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["pass"] == $_POST["passhint"]) {
        $pass = password_hash($_POST["pass"], PASSWORD_BCRYPT);
        $pdo = new PDO("mysql:host=localhost;dbname=webstore", "root", "");
        $query = $pdo->prepare("UPDATE user SET password = :pass WHERE email = :email");
        $query->bindParam(":pass", $pass);
        $query->bindParam(":email", $_SESSION["email"]);
        $query->execute();
        header("location:../UserPanel/AllProductPanel.php");
    }else
        echo '<h3 class="error">Password hint is incorrect.</h3>';
}