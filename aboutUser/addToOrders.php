<?php
session_start();
use select\Select;

require_once '../utility_class/Select.php';
require_once '../utility_class/SQL.php';
require_once '../utility_class/connect.php';
$select = new Select();
$sql=new SQL();
$connect=new connect();
$last_order_ids=[];
$pdo=$connect->connectToDatabase();
$user=$select->fetch('user','email',$_SESSION['email']);
$cart_items=$select->fetchAll('cart_items','user_id',$user['ID']);

foreach($cart_items as $cart_item){
    $query=$pdo->prepare("INSERT INTO orders(user_id,status) VALUES(:user_id,:status)");
    $query->bindValue(':user_id',$cart_item['user_id']);
    $query->bindValue(':status','1');
    $query->execute();
    $last_order_ids[]=$pdo->lastInsertId();
}

$i=0;

foreach ($cart_items as $cart_item) {
    $price=$select->fetch('product','ID',$cart_item['product_id']);
    $total_price=$price['price'] * $cart_item['quantity'];
    $query=$pdo->prepare("INSERT INTO orders_details(order_id,product_id,quantity,total_price) VALUES(:order_id,:product_id,:quantity,:total_price)");
    $query->bindValue(':order_id',$last_order_ids[$i]);
    $query->bindValue(':product_id',$cart_item['product_id']);
    $query->bindValue(':quantity',$cart_item['quantity']);
    $query->bindValue(':total_price',$total_price);
    $query->execute();
    $i++;
}

header('location: http://localhost/E-commerce%20Website/UserPanel/AllProductPanel.php');


