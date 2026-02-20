<?php

require_once 'vendor/autoload.php';

use App\Database;
use App\Kniha;

$connect = new Database();
$db = $connect->pripojDb();

if($db){
   /*
    $dunaj = new Kniha("Dunaj", "Evita Twardzik","12345",1);
    
    if($dunaj->pridajKnihu($db)){
        echo "Kniha bola pridana";
    }else{
        echo "Kniha sa nepodarila pridat";
    }
   

  
    $isbn = "12345678";
    $kniha = Kniha::hladajPodlaIsbn($db, $isbn);

    echo $kniha->getInfo();
    $kniha->pozicaj();
    $kniha->ulozZmeny($db);
    echo "Zmena bola zapisana<br>";
    echo $kniha->getInfo();
   
  $zoznam = Kniha::vsetkyKnihy($db);
  */

    $isbn = "123";
    $kniha = Kniha::zmazKnihu($db, $isbn);

    if($kniha){
        echo "kniha bola zmazana!!!";
    }else{
        echo "Kniha sa v databaze nenachadza!!!";
    }

}




