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
    <form method="post" action="Edit.php" class="form" enctype="multipart/form-data">

        <label>Where : </label>
        <select name="sw">
            <option>ID</option>
            <option>product_name</option>
            <option>description</option>
            <option>price</option>
            <option>stock_quantity</option>
            <option>category</option>
            <option>image_path</option>
        </select>

        <label>Value : </label><input type="text" name="where" required>

        <label>Set : </label>
        <select name="ss">
            <option>product_name</option>
            <option>description</option>
            <option>price</option>
            <option>stock_quantity</option>
            <option>category</option>
            <option>image_path</option>
        </select>
        <label>Value : </label><input type="text" name="set">

        <input type="submit" value="Edit" class="btn" style="height: 40px; margin-top: 9%">

    </form>
</div>
</body>
</html>
<?php
require '../classes/Select.php';
use select\Select;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new PDO("mysql:host=localhost;dbname=webstore", "root", "");
    $select = new Select();
    $result = $select->fetch($pdo, 'product', $_POST["sw"], $_POST["where"]);
    if (!$result)
        exit("<p class='error'>There is no column</p>");
    if ($_POST['ss'] == 'image_path') {
        if ($result && file_exists($result['image_path'])) {
            unlink($result['image_path']);
        }
        try {
            $SQL = "UPDATE product SET " . $_POST["ss"] . "=:set" . " WHERE " . $_POST["sw"] . "=:where";
            $query = $pdo->prepare($SQL);
            $query->bindParam(":set", $_POST["set"], PDO::PARAM_STR);
            $query->bindParam(":where", $_POST["where"], PDO::PARAM_STR);
            $query->execute();
        } catch (PDOException $e) {
            echo "<p class='error'>Sorry, there was an error." . $e->getMessage() . "</p>";
        }
    }
}
