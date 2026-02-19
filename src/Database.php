<?php

namespace App;
use PDO;

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
        }
        catch(PDOException $e){
            echo "Chyba pripojenia: $e->getMessage()";
        }

        return $this->conn;
    }

}
