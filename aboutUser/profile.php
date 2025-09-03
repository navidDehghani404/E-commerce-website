<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="AU-css-js/style.css">
    <script src="AU-css-js/prof.js" type="text/javascript"></script>
</head>
<body>
<?php
session_start();
require '../utility_class/Select.php';
use select\Select;

if (!isset($_SESSION['email'])) {
    header('Location: ../Login-form/Login.php');
    exit;
}

$select = new Select();
$pdo = new PDO('mysql:host=localhost;dbname=webstore', 'root', '');
$result = $select->fetch('user', 'email', $_SESSION['email']);

if ($result):
    $img_path = !empty($result['profile_path']) ? $result['profile_path'] : '../profiles/def.png';
    $user_name = !empty($result['user_name']) ? $result['user_name'] : 'Unknown User';
    ?>
    <div class="profile-container">
        <div class="rounded-circle overflow-hidden">
            <img src="<?= $img_path ?>" alt="Profile" class="profile-img rounded-circle">
        </div>
        <div class="profile-info">
            <h2><?= htmlspecialchars($user_name) ?></h2>
        </div>
        <button class="btn btn-primary changeBtn" onclick="changeProfile()">Change</button>
    </div>

    <div class="addressAreaDiv">
        <h4>Address:</h4>
        <h5 class="addressArea"><?= htmlspecialchars($result['address']) ?></h5>
    </div>
<?php endif; ?>
</body>
</html>
