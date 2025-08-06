<?php
require_once "../utility_class/SQL.php";
$sql=new SQL();
$sql->edit('orders','send_status','1','ID',$_GET['id']);
header('Location: AdminPanel.php');