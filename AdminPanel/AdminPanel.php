<!DOCTYPE html>
<html>
<head>
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="AP-css-js/AdminPanel.css">
    <script src="AP-css-js/AdminPanel.js" type="text/javascript"></script>
</head>
<div class="div1">
    <button onclick="Home()" style="margin-left: 0">Home</button>
    <button onclick="Add()">Add</button>
    <button onclick="Edit()" id="Edit">Edit</button>
    <button onclick="Remove()" id="Remove">Remove</button>
</div>
<body>
<table class='table table-bordered table-info'>
    <tr>
        <th>user name</th>
        <th>address</th>
        <th>email</th>
        <th>date</th>
        <th>status</th>
        <th>product code</th>
        <th>product name</th>
        <th>quantity</th>

    </tr>
    <?php
    date_default_timezone_set('Asia/Tehran');
    use select\Select;

    require_once '../utility_class/connect.php';
    require_once '../utility_class/Select.php';
    require_once '../utility_class/SQL.php';

    $connect=new connect();
    $select=new Select();
    $pdo=$connect->connectToDatabase();

    $query=$pdo->prepare("SELECT * FROM orders");
    $query->execute();
    $result=$query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        echo '<tr>';
        $user=$select->fetch('user','ID',$row['user_id']);
        echo "<td>".$user['user_name']."</td>";
        echo "<td>".$user['address']."</td>";
        echo "<td>".$user['email']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "<td>".$row['status']."</td>";
        $od=$select->fetch('orders_details','order_id',$row['ID']);
        $product=$select->fetch('product','ID',$od['product_id']);
        echo "<td>".$product['ID']."</td>";
        echo "<td>".$product['product_name']."</td>";
        echo "<td>".$od['quantity']."</td>";
        echo "<td><a class='btn btn-info' href='changeStatus.php?orderId=".$row['ID']."'>Sent</a></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
<?php