<?php

namespace App;
use PDO;

class Pkniha extends Kniha{
    public function pridajKnihu($db){
        $sql = "INSERT INTO knihy(nazov, autor, isbn, dostupnost, typ) VALUE (:nazov, :autor, :isbn, :dostupnost, 'papierova')";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":nazov", $this->nazov);
        $stmt->bindParam(":autor", $this->autor);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":dostupnost", $this->dostupnost);
            
        if($stmt->execute()){
            return true;
        } 

    return false;
    }
}