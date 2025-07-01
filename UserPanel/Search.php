<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Panel</title>
    <link rel="stylesheet" href="UP-css-js/Upanel.css">
</head>
<body>
<form method="post" action="Search.php" class="SearchMainForm">
    <input name="search" type="search" placeholder="search" class="SearchTxt">
    <button type="submit" class="SearchBtn">Search</button>
</form>
<div class="BigFormDiv">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo= new PDO("mysql:host=localhost;dbname=webstore", "root", "");
    $query = $pdo->prepare("SELECT *
FROM product
WHERE category = :category
   OR product_name LIKE CONCAT(:category, '%')");
    $query->bindParam(':category', $_POST['search']);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
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
}
?>
</div>
</body>
</html>