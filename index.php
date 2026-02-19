<?php

require_once 'vendor/autoload.php';

use App\Database;
use App\Kniha;

$connect = new Database();
$db = $connect->pripojDb();

if($db){
    $janosik = new Kniha("Janosik", "Stano Flak","45555151",1);
    
    if($janosik->pridajKnihu($db)){
        echo "Kniha bola pridana";
    }else{
        echo "Kniha sa nepodarila pridat";
    }
}




