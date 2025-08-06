<?php
namespace select;
require_once 'SQL.php';
require_once 'connect.php';

use Connect;
use PDO;
use SQL;

class Select extends SQL {
    public function __construct(){
        parent::__construct();
    }
    function fetch($table_name,$feature,$search)
    {
            $query = $this->pdo->prepare("SELECT * FROM $table_name WHERE $feature=:search");
            $query->bindParam(':search',$search);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
    }
    function fetchAll($table_name,$feature,$search)
    {
        try {
            if ($feature == null && $search == null) {
                $query = $this->pdo->prepare("SELECT * FROM $table_name");
            }else {
                $query = $this->pdo->prepare("SELECT * FROM $table_name WHERE $feature=:search");
                $query->bindParam(':search',$search);
            }
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}