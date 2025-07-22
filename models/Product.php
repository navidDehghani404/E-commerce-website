<?php

namespace models;

use PDO;

class Product
{
    private $pdo;

    function __construct($pdo){
        $this->pdo = $pdo;
    }

    function show($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM product WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if($row) {
            return $row;
        }
    }

    function showAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM product");
        $query->execute();
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

}