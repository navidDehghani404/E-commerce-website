<?php
class Connect{
    public $sql="mysql";
    public $host="localhost";
    public $db="store";
    public $username="root";
    public $password="";

    public $charset="utf8";


    function createDsn():string
    {
        $dsn="$this->sql:host=$this->host;dbname=$this->db";
        return $dsn;
    }
    function connectToDatabase(): PDO
    {
        $pdo=new PDO($this->createDsn(),$this->username,$this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}