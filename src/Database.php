<?php

namespace App;
use PDO;
use PDOException;

class Database{
    private string $host = "localhost";
    private string $db_name = "kniznica";
    private string $username = "root";
    private string $password = "";
    public $conn;

    public function pripojDb(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host={$this->host}; dbname={$this->db_name}", $this->username, $this->password);
            echo "Databaza je pripojena.";
        }
        catch(PDOException $e){
            echo "Databazu sa nepodarilo pripojit: ".$e->getMessage();
        }

        return $this->conn;
    }

}
