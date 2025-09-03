<?php
require_once "../utility_class/SQL.php";
$sql=new SQL();
$sql->edit('orders','status','2','ID',$_GET['orderId']);
header('Location: AdminPanel.php');