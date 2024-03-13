<?php

function load($class){
    include("Entity/".$class.".class.php");
}

spl_autoload_register("load");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initiating the manager
$citationManager = new CitationManager();

// Exibindo as citações
foreach ($citationManager->readAll() as $citation) {
    // Corrected the way to access the author's full name
    echo "Auteur: " . $citation->getAuteur()->getNomComplet() . "<br>";
    echo "Texte: " . $citation->getTexte() . "<br>";
    echo "Date: " . $citation->getDate()->format("Y-m-d") . "<br><br>";
}