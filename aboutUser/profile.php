<!DOCTYPE html>
<html lang="fa">
<head>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="AU-css-js/style.css">
    <script src="AU-css-js/prof.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
session_start();
require '../utility_class/Select.php';
use select\Select;
if (!isset($_SESSION['email'])) {
    header('Location: ../Login-form/Login.php');
}
$select = new Select();
$pdo = new PDO('mysql:host=localhost;dbname=webstore', 'root', '');
$result=$select->fetch('user','email',$_SESSION['email']);
if ($result){
    echo "<div class='div1'>";
    $img_path=$result['profile_path'];
    if (empty($img_path)) {
        echo "<div class='rounded rounded-circle div2'><img src='../profiles/def.png' class='imgProf rounded rounded-circle'></div>";
    }
    else {
        echo "<div class='rounded rounded-circle div2'><img src='$img_path' class='imgProf rounded rounded-circle'></div>";
    }
    echo "<div style='width: 53%;'>";
    if(empty($result['user_name'])){
        echo "<h2 class='mx-5'>"."Unknown User"."</h2>";
    }
    else{
        echo "<h2 class='mx-5'>".$result['user_name']."</h2>";
    }
    echo "</div>";
}
    echo "<button class='btn btn-primary btn-lg changeBtn' onclick='changeProfile()'>Change</button>";
    echo "</div>";
    echo "<div class='addressAreaDiv'>";
    echo "<h4>Address : </h4>";
    echo "<h5 class='addressArea'>".$result['address']."</h5>";
    echo "</div>";
?>
</body>
</html>