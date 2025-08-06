<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="AU-css-js/CartItems.css" rel="stylesheet">
</head>
<body>
<div class="mainDivCart">
    <?php
    session_start();
    require '../utility_class/Select.php';
    require_once '../Cart/Cart.php';
    use cart\Cart;
    use select\Select;
    if (empty($_SESSION['email'])){
        exit('<div class="alert alert-danger text-center DivError" role="alert"><h2>Error</h2>
<p>Please log in and see your products</p>
</div>');
    }
    $u_id=null;
    $NumberOfProducts=0;
    $TotalPrice=0;
    try {
        $connect=new Connect();
        $select = new Select();
        $u_result=$select->fetch('user','email',$_SESSION['email']);
        if ($u_result){
            $u_id = $u_result['ID'];
        }
        $ci_result=$select->fetchAll('cart_items','user_id',$u_id);
        foreach ($ci_result as $item){
            $p_result=$select->fetchAll('product','ID',$item['product_id']);

                    foreach ($p_result as $row) {
            echo "<div class='FormDiv'>";
            echo "<form method='get' action='../UserPanel/ProductPanel.php'>";
            $path = $row['image_path'];
            echo "<img src='$path' class='images'>";
            echo "<div style='height: 9vh;padding: 2%'>";
            echo "<h3 class='mt-3'>" . $row['product_name'] . "</h3>";
            echo "</div>";
            echo "<h1 class='mt-4'>" . '$' . $row['price'] . "</h1>";
            echo "<h3 class='mt-3'>" . 'Quantity : ' . $item['quantity'] . "</h3>";
            $id = $row['ID'];
            echo "<input type='hidden' name='id' value='$id'>";
            echo "<button type='submit' value='vst' class='btnn mt-1'>Visit</button>";;
            echo "</form>";
            echo "<form method='post' action='CartItems.php'>";
            echo "<input type='hidden' name='id' value='$id'>";
            echo "<button type='submit' name='btn' value='del' class='btnn mt-1'>Delete</button>";
             echo "</form>";
            echo "</div>";
            $NumberOfProducts++;
            $TotalPrice=$TotalPrice+($row['price']*$item['quantity']);
        }
        }
    }catch (PDOException $e) {
    }
    ?>
</div>
<footer class="footerDiv">
    <div style="width: 50%">
        <div class="d-flex font">
            <?php
            echo "<p>Number of products : </p>";
            echo "<p style='margin-left: 1%'>$NumberOfProducts</p>";
        echo "</div class>";
        echo "<div class='d-flex font'>";
        echo "<p style='margin-left: 30.5%'>Total price : </p>";
        echo  "<p style='margin-left: 1%'>".'$ '.$TotalPrice."</p>"
        ?>
        </div>
    </div>
    <div style="width:50%" class="justify-content-center align-items-center d-flex">
        <?php
        $TotalPrice=$TotalPrice*800000;
            echo "<a class='btn btn-primary border-white btn-lg btn2' target='_blank' style='width: 40%' href='zarinpal/pay.php?total=$TotalPrice'>Order</a>";
           ?>
    </div>
</footer>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $cart = new Cart();
        $pdo=new PDO("mysql:host=localhost;dbname=webstore", "root", "");
        $cart->removeFromCart($pdo,$u_id,$_POST['id']);
        header("Location: " . $_SERVER['REQUEST_URI']);
}