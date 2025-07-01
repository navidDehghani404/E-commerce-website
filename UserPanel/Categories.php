<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="UP-css-js/hamberger.css">
    <link rel="stylesheet" href="UP-css-js/Categories.css">
    <link href="UP-css-js/Upanel.css" rel="stylesheet">
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
       <form method="post" action="Categories.php">
           <?php
           $array2=array();
           $pdo=new PDO("mysql:host=localhost;dbname=webstore","root","");
           $query=$pdo->prepare("SELECT category FROM product");
           $query->execute();
           $result=$query->fetchAll();
           foreach($result as $row){
               $array1[]=strtolower($row['category']);
           }
           for ($i=0;$i<count($array1);$i++){
               if (!in_array($array1[$i], $array2)){
                   $array2[]=$array1[$i];
               }
           }
           foreach ($array2 as $value){
               echo "<li><input name='btn' type='submit' value=".ucfirst($value).">";
           }
           ?>
       </form>
        </ul>

    </nav>
</div>
</body>
</html>
<?php
require '../classes/Select.php';
use select\Select;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo=new PDO("mysql:host=localhost;dbname=webstore","root","");
    $select = new Select();
    $result=$select->fetchAll($pdo,'product','category',$_POST['btn']);
    echo "<div class='BigFormDiv'>";
    foreach($result as $row){
        try{
            echo "<div class='FormDiv'>";
            echo "<form method='get' action='ProductPanel.php'>";
            $path = $row['image_path'];
            echo "<img src='$path' class='images'>";
            echo "<div style='height: 8vh'>";
            echo "<h3 style='font-size: 115%'>" . $row['product_name'] . "</h3>";
            echo "</div>";
            echo "<h1 style='margin-top: 5%'>" . '$' . $row['price'] . "</h1>";
            $id = $row['ID'];
            echo "<input type='hidden' name='id' value='$id'>";
            echo "<button type='submit' class='btn'>Visit</button>";
            echo "</form>";
            echo "</div>";

        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    echo "</div>";
}
