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
            $connect= new  Connect();
            $user= new \models\User($connect->connectToDatabase());
            $user->signUp($_SESSION["email"],$_SESSION["password"]);
            unset($_SESSION["email"]);
            unset($_SESSION["password"]);
        }catch (PDOException $e) {
            echo "<p class='error'>".$e->getMessage()."</p><br>";
        }
        header("Location:../Login-form/Login.php");
    }
    else{
        echo "<p class='error'>The verification code is wrong.try again!</p><br>";
    }
}