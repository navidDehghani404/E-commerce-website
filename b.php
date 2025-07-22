<?php
require 'utility_class/SQL.php';

$sql = new SQL();
echo $sql->insert('user',array('name'=>'ali','family'=>'rezaee'));