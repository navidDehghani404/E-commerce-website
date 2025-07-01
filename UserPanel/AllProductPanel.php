<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <link href="UP-css-js/Upanel.css" rel="stylesheet">
    <link href="UP-css-js/hamberger.css" rel="stylesheet">
    <script src="UP-css-js/Upanel.js"></script>
</head>
<body>
<header style="display: flex" class="head">
    <div onclick="categories()" class="headObj">Categories</div>
    <div onclick="search()" class="headObj">Search</div>
        <div onclick="signup()" class="headObj">Sign Up</div>
        <div onclick="login()" class="headObj">Login</div>
</header>
<div class="menu-container">
    <input type="checkbox" id="menu-toggle" />
    <label for="menu-toggle" class="menu-icon">
        <span></span>
        <span></span>
        <span></span>
    </label>
    <nav class="menu">
        <ul>
            <li><a href="../aboutUser/profile.php">Profile</a></li>
            <li><a href="../aboutUser/CartItems.php">My shopping cart</a></li>
            <li><a href="#">About us</a></li>
        </ul>
    </nav>
</div>
<div class="BigFormDiv">
    <?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=webstore", "root", "");
        $query = $pdo->prepare("SELECT * FROM product");
        $query->execute();
        $result = $query->fetchAll();
        foreach ($result as $row) {
                echo "<div class='FormDiv'>";
                echo "<form method='get' action='ProductPanel.php'>";
                $path = $row['image_path'];
                echo "<img src='$path' class='images'>";
                echo "<div style='height: 8vh'>";
                echo "<h3 style='font-size: 115%'>" . $row['product_name'] . "</h3>";
                echo "</div>";
                echo "<h1 style='margin-top: 5%'>" . '$' . $row['price'] . "</h1>";
                $id = $row['ID'];
                echo "<button type='submit' class='btn'>Visit</button>";
                echo "<input type='hidden' name='id' value='$id'>";
                echo "</form>";
                echo "</div>";
        }
    }catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
</div>
</body>
</html>