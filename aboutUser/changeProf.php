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
require '../classes/Select.php';
use select\Select;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo=new PDO("mysql:host=localhost;dbname=webstore","root","");
    if (!isset($_SESSION["email"])) {
        exit("<h3 class='error'>Please Login</h3>");
    }
    if (!empty($_POST['username'])) {
        $query = $pdo->prepare("UPDATE user SET user_name=:username WHERE email=:email");
        $query->bindParam(':username', $_POST['username']);
        $query->bindParam(':email', $_SESSION['email']);
        $query->execute();
    }
    if (!empty($_POST['address'])) {
        $query = $pdo->prepare("UPDATE user SET address=:address WHERE email=:email");
        $query->bindParam(':address', $_POST['address']);
        $query->bindParam(':email', $_SESSION['email']);
        $query->execute();
    }
    if (!empty($_FILES['img']['name'])) {

        $types = ['jpg', 'png', 'jpeg'];
        if (!in_array(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION), $types)) {
            exit("<h3 class='error'>Only jpg, png, jpeg files are allowed</h3>");
        }
        $path = '../profiles/' .uniqid('prof',true).'.'.pathinfo($_FILES['img']['name'],PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['img']['tmp_name'], $path)) {
            $select = new Select();
            $results = $select->fetch($pdo, 'user', 'email', $_SESSION['email']);
            if ($results) {
                if (!empty($results['profile_path'])) {

                    $file = $results['profile_path'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            $query = $pdo->prepare("UPDATE user SET profile_path=:profile WHERE email=:email");
            $query->bindParam(':profile', $path);
            $query->bindParam(':email', $_SESSION['email']);
            $query->execute();

        } else {
            exit("<h3 class='error'>There is an error</h3>");
        }
    }
    header('location: profile.php');
}
