<?php
session_start();
require_once '../../utility_class/ZarinPal.php';
use utility_class\ZarinPal;
$pay = new ZarinPal($_SESSION['amount']);
$validate=$pay->validation($_GET['Authority']);
if ($validate['result'] === true) {
    header("Location: ../addToOrders.php");
}else
    echo $validate['message'].' Code : '.$validate['code'];