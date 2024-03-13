<?php
// Informations de configuration de la base de données
// http://localhost:8888/CitationSysteme/config/db-config.php

// Accède aux variables du système dans le fichier .env
require_once '/Applications/MAMP/htdocs/CitationSysteme/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Hôte du serveur de base de données
define('DB_HOST', $_ENV['DB_HOST']);

// Nom d'utilisateur de la base de données
define('DB_USER', $_ENV['DB_USER']);

// Mot de passe de la base de données
define('DB_PASS', $_ENV['DB_PASS']);

// Nom de la base de données
define('DB_NAME', $_ENV['DB_NAME']);

// Tentative de connexion à la base de données
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Définir le mode d'erreur de PDO sur exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
