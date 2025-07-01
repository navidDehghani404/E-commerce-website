<?php
namespace select;
use PDO;

class Select {
    function fetch($pdo,$table_name,$feature,$search)
    {
            $query = $pdo->prepare("SELECT * FROM $table_name WHERE $feature=:search");
            $query->bindParam(':search',$search);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
    }
    function fetchAll($pdo,$table_name,$feature,$search)
    {
        try {
            $query = $pdo->prepare("SELECT * FROM $table_name WHERE $feature=:search");
            $query->bindParam(':search',$search);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}