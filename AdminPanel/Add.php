<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="AP-css-js/AdminPanel.css">
    <script src="AP-css-js/AdminPanel.js" type="text/javascript"></script>

</head>
<body>
<div class="div1">
    <button onclick="Home()" style="margin-left: 0">Home</button>
    <button onclick="Add()">Add</button>
    <button onclick="Edit()" id="Edit">Edit</button>
    <button onclick="Remove()" id="Remove">Remove</button>
</div>
<div class="FormContainer">
    <form method="post" action="Add.php" class="form" enctype="multipart/form-data">
        <label>Product Name : </label><input type="text" name='product' required>
        <label>Description : </label><textarea name='description'></textarea>
        <label>Price : </label><input type="text" name='price' required>
        <label>Quantity : </label><input type="text" name='stock_quantity'>
        <label>Category : </label><input type="text" name='category' required>
        <label>Image : </label><input type="file" name='image_path' required>
        <input type="submit" class="btn" style="height: 40px;" value="Add">
    </form>
</div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dirc='../images/';
    $path=$dirc.uniqid('img',true).'.'.pathinfo($_FILES['image_path']['name'], PATHINFO_EXTENSION);
    if (!move_uploaded_file($_FILES['image_path']['tmp_name'],$path)) {
        exit("<p>Sorry, there was an error uploading your file.</p>");
    }
    $image_path=$path;
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=webstore", "root", "");

        $query = $pdo->prepare('INSERT INTO product(product_name,description,price,stock_quantity,category,image_path)
VALUES(:product, :description, :price, :stock_quantity, :category, :image_path)');

        $query->bindParam(':product', $_POST['product']);
        $query->bindParam(':description', $_POST['description']);
        $query->bindParam(':price', $_POST['price']);
        $query->bindParam(':stock_quantity', $_POST['stock_quantity']);
        $query->bindParam(':category', $_POST['category']);
        $query->bindParam(':image_path', $image_path);
        $query->execute();
    } catch (PDOException $e) {
        echo "<p class='error'>Sorry, there was an error.".$e->getMessage()."</p>";
    }
}