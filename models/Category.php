<?php
namespace models;
use PDO;
class Category
{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    function showAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM category");
        $query->execute();
        return $query->fetchAll();
    }
}