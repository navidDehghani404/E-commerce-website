<?php

use select\Select;

require_once 'utility_class/Select.php';
require_once 'utility_class/SQL.php';

$select = new Select();
$row=$select->fetch('user','ID',7);
if ($row){
    echo $row['email'];
}