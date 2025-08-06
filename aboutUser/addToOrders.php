<?php
session_start();
use select\Select;

require_once '../utility_class/Select.php';
require_once '../utility_class/SQL.php';
require_once '../utility_class/connect.php';
$select = new Select();
$sql=new SQL();
$connect=new connect();
$pdo=$connect->connectToDatabase();
$user=$select->fetch('user','email',$_SESSION['email']);
$cart_item=$select->fetchAll('cart_items','user_id',$user['ID']);
foreach($cart_item as $cart_items){
    $query=$pdo->prepare("INSERT INTO orders(user_id,product_id,quantity,send_status) VALUES(:user_id,:product_id,:quantity,:send_status)");
    $query->bindValue(':user_id',$cart_items['user_id']);
    $query->bindValue(':product_id',$cart_items['product_id']);
    $query->bindValue(':quantity',$cart_items['quantity']);
    $query->bindValue(':send_status',0);
    $query->execute();
}
header('location: http://localhost/E-commerce%20Website/UserPanel/AllProductPanel.php');


