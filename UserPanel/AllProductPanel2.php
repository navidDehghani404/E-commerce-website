<!DOCTYPE html>
<html lang="fa">
<link rel="stylesheet" href="UP-css-js/AllProductPanel.css" type="text/css">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Product Template</title>
    <link rel="stylesheet" href="styles.css" />
    <script defer src="script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <h2>All Products</h2>
    <p>Discover our complete collection of premium products</p>
    <div class="filters">
        <button class="filter active">All Products</button>
        <?php
        require_once "../utility_class/Select.php";
        use select\Select;
        $select = new Select();
        $categories=$select->fetchAll('category',null,null);
        foreach ($categories as $category) {
            echo "<button class='filter'>".$category['name']."</button>";
        }
        ?>
    </div>

    <div class="products">
        <div class="product-card">
            <img src="https://i.ibb.co/Y8fMj1F/headphone.jpg" alt="Wireless Bluetooth Headphones" />
            <h4>Wireless Bluetooth Headphones</h4>
            <div class="rating">★★★★☆ 4.8 (234)</div>
            <div class="price"><span class="current">$89.99</span> <span class="old">$129.99</span></div>
            <button class="add-to-cart">
                Add to Cart
                <i class="fas fa-shopping-cart cart-icon"></i>
            </button>
        </div>

        <?php

//        use models\Product;
//
//        require_once '../utility_class/connect.php';
//        require_once '../models/Product.php';
//        try {
//            $connect=new connect();
//            $result=new Product($connect->connectToDatabase());
//            foreach ($result->showAll() as $row) {
//                echo "<div class='product-card'>";
//                $path = $row['image_path'];
//                echo "<img src='$path' alt='USB-C Hub Adapter' />";
//
//                echo "<h4>".$row['product_name']."</h4>";
//
//                echo "</div>";
//                echo "<h1 style='margin-top: 5%'>" . '$' . $row['price'] . "</h1>";
//                echo "<div class='price'><span class='current'>".$row['price']."</span></div>";
//                $id = $row['ID'];
//                echo "<form method='get' action='ProductPanel.php'>";
//                echo "<button class='add-to-cart' type='submit'>Add to Cart<i class='fas fa-shopping-cart cart-icon'></i></button>";
//                echo "<input type='hidden' name='id' value='$id'>";
//                echo "</form>";
//                echo "</div>";
//            }
//        }catch (PDOException $e) {
//            echo $e->getMessage();
//        }
//        ?>

        <?php
                use models\Product;

        require_once '../utility_class/connect.php';
                require_once '../models/Product.php';
                try {
                    $connect=new connect();
                    $result=new Product($connect->connectToDatabase());
                    foreach ($result->showAll() as $row) {
                        $path = $row['image_path'];
                        $id = $row['ID'];
                    echo   "<div class='product-card'>";
            echo "<img src='$path' alt='USB-C Hub Adapter' />";
            echo "<h4>".$row['product_name']."</h4>";
            echo "<div class='rating'>★★★★☆ 4.5 (98)</div>";
            echo "<div class='price'><span class='current'>".'$'.$row['price']."</span></div>";
            echo "<form method='get' action='ProductPanel.php'>";
            echo "<input type='hidden' name='id' value='$id'>";
            echo "<button class='add-to-cart'> Add to Cart <i class='fas fa-shopping-cart cart-icon'></i></button>";
            echo "</form>";
        echo "</div>";
                    }
                }catch (PDOException $e) {
                    echo $e->getMessage();
                }
        ?>

        <div class="product-card">
            <img src="https://i.ibb.co/8g5PjW3/usb-hub.jpg" alt="USB-C Hub Adapter" />
            <h4>USB-C Hub Adapter</h4>
            <div class="rating">★★★★☆ 4.5 (98)</div>
            <div class="price"><span class="current">$34.99</span> <span class="old">$49.99</span></div>
            <button class="add-to-cart">
                Add to Cart
                <i class="fas fa-shopping-cart cart-icon"></i>
            </button>
        </div>
    </div>
</div>
</body>
</html>
