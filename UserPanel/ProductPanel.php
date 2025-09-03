<!DOCTYPE html>
<html lang="fa">
<head>
    <link href="UP-css-js/Ppanel.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Panel</title>
</head>
<body>
<div class="container">
    <?php
    require_once "../utility_class/Select.php";
    use select\Select;
    session_start();
    if (isset($_GET['id'])){
        $_SESSION['p.id'] = $_GET['id'];
    }
    $select=new Select();
    $result=$select->fetch('product','id',$_SESSION['p.id']);
    if ($result){
        $path=$result['image_path'];
        echo "<div class='product-image'><img src='$path' alt='Product'></div>";
        echo "<div class='product-info'>";
        $category=$select->fetch('category','ID',$result['category_id']);
        echo "<h4>".$category['name']."</h4>";
        echo "<div class='divider'></div>";
        echo "<h2>".$result['product_name']."</h2>";
        echo "<h3>".$result['description']."</h3>";
        echo "<div class='price-section'>";
        echo "<h1>".'$'.$result['price']."</h1>";
        echo "<h2>موجودی: ".$result['stock_quantity']."</h2>";
        echo "<form method='post' action='ProductPanel.php'>";
        echo "<input type='number' name='quantity' class='num' placeholder='تعداد'>";
        echo "<button type='submit' name='btn' class='btn'>افزودن به سبد</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
</body>
</html>
<?php
require '../Cart/Cart.php';
use cart\Cart;

if($_SERVER['REQUEST_METHOD']=='POST') {
    if (!isset($_SESSION["email"])){
        exit("<h1 style='display: flex;justify-content: center;align-items: center ;margin-top: 3%'>Please Login</h1>");
    }
    else{
        $select=new Select();
        $cart=new Cart();
        $connect=new Connect();
        $result = $select->fetch('user','email',$_SESSION['email']);
        if($result){
            if (!empty($_POST['quantity']) && $_POST['quantity']>0)
                $cart->addToCart($connect->connectToDatabase(),$result['ID'],$_SESSION['p.id'],$_POST['quantity']);
        }
    }
}
?>
