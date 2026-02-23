<?php

namespace App;
use PDO;

abstract class Kniha
{
    protected string $nazov;
    protected string $autor;
    protected string $isbn;
    protected int $dostupnost;
    

    public function __construct($nazov, $autor, $isbn, $dostupnost){
        $this->nazov = $nazov;
        $this->autor = $autor;
        $this->isbn = $isbn;
        $this->dostupnost = $dostupnost;
       
    }

    public function getInfo(){
        return "Nazov knihy: {$this->nazov}<br>Autor knihy: {$this->autor}<br>Kod ISBN: {$this->isbn}<br>Stav: {$this->dostupnost}<br>";
    }

    public function getNazov(){
        return $this->nazov;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function getIsbn(){
        return $this->isbn;
    }

    public function getDostupnost(){
        return $this->dostupnost;
    }


    public function pozicaj(){
        if($this->dostupnost){
            $this->dostupnost = 0;
        }else{
            echo "Chyba: Kniha je uz pozicana!<br>";
        }
    }

    public function vrat(){
        $this->dostupnost = 1;
    }

    abstract public function pridajKnihu($db);

    public static function hladajPodlaIsbn($db, $isbn){
        $sql = "SELECT nazov, autor, isbn, dostupnost, typ, velkostMB FROM knihy WHERE isbn = :isbn LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":isbn", $isbn);

        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($row["typ"] === "papierova"){
                $objekt = new Pkniha($row["nazov"], $row["autor"], $row["isbn"], $row["dostupnost"]);
                return $objekt;
            }else{
                $objekt = new Ekniha($row["nazov"], $row["autor"], $row["isbn"], $row["dostupnost"], $row["velkostMB"]);
                return $objekt;
            }
        }
        return null;
    }
    

    public function ulozZmeny($db){
        $sql = "UPDATE knihy SET dostupnost = :dostupnost WHERE isbn = :isbn" ;

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":dostupnost", $this->dostupnost);
        $stmt->bindParam(":isbn", $this->isbn);
        
    return $stmt->execute();
    }
    
    public static function vsetkyKnihy($db, $hladat = ""){
        $zoznamKnih = [];

        if(!empty($hladat)){
            $sql = "SELECT * FROM knihy WHERE nazov LIKE :hladat OR autor LIKE :hladat";

            $stmt = $db->prepare($sql);
            $term = "%$hladat%";
            $stmt->bindParam(":hladat", $term);

            $stmt->execute();

        }else{
            $sql = "SELECT * FROM knihy";
            $stmt = $db->query($sql);
        }
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if($row["typ"] === "papierova"){
                $kniha = new Pkniha($row["nazov"], $row["autor"], $row["isbn"], $row["dostupnost"]);
                $zoznamKnih[] = $kniha;
            }else{
                $kniha = new Ekniha($row["nazov"], $row["autor"], $row["isbn"], $row["dostupnost"],$row["velkostMB"]);
                $zoznamKnih[] = $kniha;
            }
          
        }
    return $zoznamKnih;
    }

    public static function zmazKnihu($db, $isbn){
        $sql = "DELETE FROM knihy WHERE isbn = :isbn";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":isbn", $isbn);

        if($stmt->execute()){
            return true;
        }
    return false;    
    }

}