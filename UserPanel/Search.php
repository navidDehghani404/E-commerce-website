<!DOCTYPE html>
<html lang="fa">
<head>
    <link href="UP-css-js/SearchPanel.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Panel</title>
</head>
<style>

</style>
<body>
<form method="post" action="Search.php" class="SearchMainForm">
    <input name="search" type="search" placeholder="search" class="SearchTxt">
    <button type="submit" class="SearchBtn">Search</button>
</form>
<div class="BigFormDiv">
<?php
require_once '../utility_class/connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo= new Connect();
    $pdo=$pdo->connectToDatabase();
    $search = $_POST['search']; // متن سرچ شده کاربر

    $query = $pdo->prepare("
    SELECT p.*, c.name AS category_name
    FROM product p
    JOIN category c ON p.category_id = c.id
    WHERE c.name LIKE CONCAT('%', :search, '%')
       OR p.product_name LIKE CONCAT('%', :search, '%')
");

    $query->execute([
        ':search' => $search
    ]);

    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
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