<?php

require_once 'vendor/autoload.php';

use App\Database;
use App\Kniha;
use App\Ekniha;


$connect = new Database();
$db = $connect->pripojDb();

if(!$db){
    die("Chyba pripojenia k databaze!!!!");
}

//spracovanie formulara na pridanie knihy

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pridaj"])){
    $nazov = $_POST["nazov"];
    $autor = $_POST["autor"];
    $isbn = $_POST["isbn"];
    $typ = $_POST["typ"];
    $velkost = $_POST["velkost"];

    if($typ === "papierova"){
        $novaKniha = new Kniha($nazov, $autor, $isbn, 1);
    }else{
        $novaKniha = new Ekniha($nazov, $autor, $isbn, 1, $velkost);
    }

    if($novaKniha->pridajKnihu($db)){
        header("Location: index.php?success=1");
        exit;
    }

}

//spracovanie formulara na vykonanie akcie 

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["akcia"])){
    $akcia = $_POST["akcia"];
    $isbn = $_POST["isbn_akcia"];
    $kniha_obj = Kniha::hladajPodlaIsbn($db, $isbn);

    if($akcia === "pozicaj"){
        $kniha_obj->pozicaj();
        $kniha_obj->ulozZmeny($db);
        
    }elseif($akcia === "vrat"){
        $kniha_obj->vrat();
        $kniha_obj->ulozZmeny($db);

    }elseif($akcia === "zmaz"){
        Kniha::zmazKnihu($db, $isbn);
    }

    header("Location:index.php");
    exit;

}

$kniznica = Kniha::vsetkyKnihy($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        tr:hover { background-color: #f9f9f9; }
        .status-volna { color: green; font-weight: bold; }
        .status-pozicana { color: red; font-weight: bold; }
        .typ-tag { background: #eee; padding: 2px 6px; border-radius: 4px; font-size: 0.8em; }
    </style>
</head>
<body>
    <form method="POST">
        <input type="text" name="nazov" placeholder="Názov" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        
        <select name="typ" id="typKnihy" onchange="toggleSize()">
            <option value="papierova">Papierová</option>
            <option value="ekniha">E-kniha</option>
        </select>

        <input type="number" name="velkost" id="velkostInput" placeholder="Veľkosť v MB" step="0.1" style="display:none;">
        
        <button type="submit" name="pridaj">Pridať do knižnice</button>
    </form>
   
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green; background: #e8f5e9; padding: 10px;">
            ✅ Kniha bola úspešne pridaná do knižnice!
        </p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Názov</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Typ</th>
                <th>Stav</th>
                <th>Akcia</th>                
            </tr>
        </thead>
        <tbody>
            <?php foreach($kniznica as $kniha): ?>
                <tr>
                    <td><?= $kniha->getNazov(); ?></td>
                    <td><?= $kniha->getAutor(); ?></td>
                    <td><?= $kniha->getIsbn(); ?></td>
                    <td><?= ($kniha instanceof Ekniha) ? "elektronicka -> {$kniha->getVelkostSuboru()}MB" : "papierova" ?></td>
                    <td><?= $kniha->getDostupnost(); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="isbn_akcia" value="<?= $kniha->getIsbn(); ?>">
                            <?php if($kniha->getDostupnost()): ?>
                                        <button type="submit" name="akcia" value="pozicaj">Požičať</button>
                            <?php else:?>
                                        <button type="submit" name="akcia" value="vrat">Vrátiť</button>
                            <?php endif; ?>    

                            <button type="submit" name="akcia" value="zmaz" onclick="return confirm('Naozaj zmazať!!!')">Zmaž</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <script>
    function toggleSize() {
        const typ = document.getElementById('typKnihy').value;
        const input = document.getElementById('velkostInput');
        input.style.display = (typ === 'ekniha') ? 'inline' : 'none';
    }
    </script>
</body>
</html>




