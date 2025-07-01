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
    <form method="post" action="Verification.php" class="mainForm">
        <h1 class="formH1">Account Verification</h1>
        <input type="text" name="code" required placeholder="Code">
        <input type="submit" class="btn" value="Sign Up">
    </form>
</div>
</body>
</html>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["code"] == $_SESSION["code"]) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=webstore", "root", "");
            $query = $pdo->prepare("INSERT INTO user(email, password) VALUES(:email, :password)");
            $query->bindParam(":email", $_SESSION["email"]);
            $hashedPassword = password_hash($_SESSION["password"], PASSWORD_BCRYPT);
            $query->bindParam(":password", $hashedPassword);
            $query->execute();
            unset($_SESSION["email"]);
            unset($_SESSION["password"]);
        }catch (PDOException $e) {
        }
        header("Location:../Login-form/Login.php");
    }
    else{
        echo "<p class='error'>The verification code is wrong.try again!</p><br>";
    }
}