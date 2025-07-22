<?php
require_once 'connect.php';
class SQL
{
    protected $pdo;
    function __construct(){
        $connect=new Connect();
        $this->pdo=$connect->connectToDatabase();
    }

    function insert($table,array $data)
    {
        //INSERT INTO product(product_name,description,price,stock_quantity,category,image_path) VALUES(:product, :description, :price, :stock_quantity, :category, :image_path)
        $i=0;
        $sql="INSERT INTO $table(";
        foreach($data as $key=>$value){
            $i=$i+1;
            if ($i==count($data)){
                $sql.="$key) VALUES (";
            }else
            $sql.="$key,";
        }
        $i=0;
        foreach ($data as $key=>$value){
            $i=$i+1;
            if ($i==count($data)){
                $sql.=":$key)";
            }else
                $sql.=":$key,";
        }
        $query=$this->pdo->prepare($sql);
        foreach ($data as $key=>$value){
            $query->bindParam(":$key",$value);
        }
        $query->execute();
    }

    function edit($table,$setColumn,$setValue,$whereColumn,$whereValue)
    {
        $query=$this->pdo->prepare("UPDATE $table SET $setColumn=:setValue WHERE $whereColumn=:whereValue");
        $query->bindParam(':setValue',$setValue);
        $query->bindParam(':whereValue',$whereValue);
        $query->execute();
    }

    function destroy($table,$whereColumn,$whereValue)
    {
        $query=$this->pdo->prepare("DELETE FROM $table WHERE $whereColumn=:whereValue");
        $query->bindParam(':whereValue',$whereValue);
        $query->execute();
    }
}