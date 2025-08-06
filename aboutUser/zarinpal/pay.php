<?php
require_once '../../utility_class/ZarinPal.php';
use utility_class\ZarinPal;
session_start();
$pay = new ZarinPal($_GET['total']);
$_SESSION['amount']=$_GET['total'];
if ($pay->connectResult()['result'] === true) {
    $pay->linkUrl($pay->connectResult()['data']);
}
else{
    echo $pay->connectResult()['message'].' Code : '.$pay->connectResult()['code'];
}
