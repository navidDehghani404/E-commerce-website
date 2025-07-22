<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Panel</title>
    <link rel="stylesheet" href="UP-css-js/Ppanel.css">
</head>
<body>
<div style="display: flex;width: 99%">
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
echo "<img src='$path'>";
echo "<div class='subject'>";
echo "<h4>".$result['category']."</h4>";
echo "<hr style='width: 650%'>";
echo "<h2>".$result['product_name']."</h2>";
echo "<hr style='width: 650%'>";
echo "<h3>".$result['description']."</h3>";
echo "</div>";
echo "</div>";
echo "<div class='Price'>";
echo "<h1>".'$'.$result['price']."</h1>";
echo "<h2>Stock : ".$result['stock_quantity']."</h2>";
echo "<form method='post' action='ProductPanel.php'>";
echo "<button type='submit' name='btn' class='btn' style='margin-top: 1%'>Add to cart</button>";
echo "<input type='number' name='quantity' class='num'>";
echo "</form>";
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