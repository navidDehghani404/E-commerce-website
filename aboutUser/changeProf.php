<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="AU-css-js/changeProf.css">

</head>
<body>
<div class="FormContainer">
    <form method="post" action="changeProf.php" class="form" enctype="multipart/form-data">
        <label>User Name : </label><input type="text" name='username' class="txtbox">
        <label>Address : </label><textarea name='address' class="txtbox"></textarea>
        <label>Profile : </label><input type="file" name="img" class="form-select">
        <input type="submit" class="btn_" style="height: 40px;" value="Save">
    </form>
</div>
</body>
</html>
<?php
session_start();
require_once '../utility_class/Select.php';
require_once '../utility_class/connect.php';
require_once '../utility_class/SQL.php';
require_once '../models/User.php';
use select\Select;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connect=new Connect();
    $pdo=$connect->connectToDatabase();
    $sql=new SQL();
    $user=new \models\User($pdo);
    if (!$user->loggedIn()) {
        exit("<h3 class='error'>Please Login</h3>");
    }
    if (!empty($_POST['username'])) {
        $sql->edit('user','user_name',$_POST['username'],'email',$_SESSION['email']);
    }
    if (!empty($_POST['address'])) {
        $sql->edit('user','address',$_POST['address'],'email',$_SESSION['email']);
    }
    $user->validateProfileImageAndAdd($pdo,$_FILES['img']['name'],'There is an error');
    header('location: ../UserPanel/AllProductPanel.php');
}
