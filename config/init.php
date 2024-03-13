<?php
require_once 'db-config.php';

try {
    $new_database = 'test_db';
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Définir le mode d'erreur de PDO sur exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connecté à la base de données avec succès.\n";

    $pdo->exec("DROP DATABASE IF EXISTS ". $new_database);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS ". $new_database);
    $pdo->exec('USE' . $new_database);

    // Lire le fichier SQL et exécuter les instructions pour créer les tables
    $query = file_get_contents('citation_db.sql');
    $pdo->exec($query);

    echo "La structure de la base de données a été importée avec succès.\n";

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Fermeture de la connexion
$pdo = null;