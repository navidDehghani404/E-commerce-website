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
        <th>product code</th>
        <th>product name</th>
        <th>quantity</th>
        <th>date</th>
    </tr>
    <?php
    date_default_timezone_set('Asia/Tehran');
    use select\Select;

    require_once '../utility_class/Select.php';
    require_once '../utility_class/SQL.php';
    $select = new Select();
    $sql=new SQL();
    $statuses1=$select->fetchAll('orders','send_status','1');
    foreach($statuses1 as $status1){
        if (time() >= strtotime($status1['date_time'])+604800) { // هفته به ثانیه
            $sql->destroy('orders','ID',$status1['ID']);
        }
    }
    $status0=$select->fetchAll('orders','send_status','0');
    foreach($status0 as $status){
        echo "<tr>";
        $user=$select->fetch('user','ID',$status['user_id']);
        echo "<td>".$user['user_name']."</td>";
        echo "<td>".$user['address']."</td>";
        echo "<td>".$user['email']."</td>";
        $product=$select->fetch('product','ID',$status['product_id']);
        echo "<td>".$product['ID']."</td>";
        echo "<td>".$product['product_name']."</td>";
        echo "<td>".$status['quantity']."</td>";
        echo "<td>".$status['date_time']."</td>";
        $statusId=$status['ID'];
        echo "<td><a href='http://localhost/E-commerce%20Website/AdminPanel/changeStatus.php?id=$statusId' class='btn btn-info'>Send</a></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
<?php