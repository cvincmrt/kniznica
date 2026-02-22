<?php

namespace App;
use PDO;

    class Ekniha extends Kniha{
    private float $velkostSuboru;

    public function __construct($nazov, $autor, $isbn, $dostupnost, $velkostSuboru)
    {
        parent::__construct($nazov, $autor, $isbn, $dostupnost);
        $this->velkostSuboru = $velkostSuboru;
    }

    public function stiahni(){
        echo "Stahujem eknihu .... Velkost suboru je {$this->velkostSuboru} MB.<br>";
    }



}