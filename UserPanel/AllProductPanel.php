<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <script src="UP-css-js/Upanel.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="UP-css-js/AllProductPanel.css" rel="stylesheet" type="text/css">
</head>
<body>
<header class="head">
    <div onclick="categories()" class="headObj">Categories</div>
    <div onclick="search()" class="headObj">Search</div>
    <div onclick="signup()" class="headObj">Sign Up</div>
    <div onclick="login()" class="headObj">Login</div>

    <!-- آیکن منوی همبرگری -->
    <div class="hamburger"><i class="fas fa-bars"></i></div>
</header>

<!-- Overlay -->
<div class="overlay"></div>

<!-- Side Menu -->
<div class="side-menu">
    <span class="close-btn"><i class="fas fa-times"></i></span>
    <div class="menu-items">
        <a href="../../E-commerce%20Website/aboutUser/profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="../../E-commerce%20Website/aboutUser/CartItems.php"><i class="fas fa-shopping-cart"></i> My Cart</a>
        <a href="../../E-commerce%20Website/aboutUser/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <a href="#"><i class="fas fa-info-circle"></i> About Us</a>
    </div>
</div>

<div class="BigFormDiv">
    <div class="product-grid">
        <?php
        use models\Product;

        require_once '../utility_class/connect.php';
        require_once '../models/Product.php';
        try {
            $connect = new connect();
            $result = new Product($connect->connectToDatabase());
            foreach ($result->showAll() as $row) {
                echo "<div class='product-card'>";
                echo "<form method='get' action='ProductPanel.php'>";
                $path = $row['image_path'];
                echo "<img src='$path' alt='Product Image'>";
                echo "<h3>" . htmlspecialchars($row['product_name']) . "</h3>";
                echo "<p class='price'>$" . $row['price'] . "</p>";
                $id = $row['ID'];
                echo "<button type='submit'>Visit</button>";
                echo "<input type='hidden' name='id' value='$id'>";
                echo "</form>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
    </div>
</div>

<script>
    const hamburger = document.querySelector('.hamburger');
    const overlay = document.querySelector('.overlay');
    const sideMenu = document.querySelector('.side-menu');
    const closeBtn = document.querySelector('.close-btn');

    hamburger.addEventListener('click', () => {
        overlay.classList.add('active');
        sideMenu.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        overlay.classList.remove('active');
        sideMenu.classList.remove('active');
    });

    overlay.addEventListener('click', () => {
        overlay.classList.remove('active');
        sideMenu.classList.remove('active');
    });
</script>
</body>
</html>
