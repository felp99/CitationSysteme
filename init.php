<?php

// Configuration de la base de données
$host = DB_HOST; // L'adresse du serveur de la base de données
$usuario = DB_USER; // Le nom d'utilisateur pour se connecter à la base de données
$senha = DB_PASS; // Le mot de passe associé à l'utilisateur de la base de données
$banco = DB_NAME; // Le nom de la base de données à créer ou à utiliser

// Création d'une nouvelle connexion à la base de données
$conn = new mysqli($host, $usuario, $senha);

// Vérification de la réussite de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Création de la base de données si elle n'existe pas déjà
$sql = "CREATE DATABASE IF NOT EXISTS $banco";
if ($conn->query($sql) === TRUE) {
    echo "La base de données a été créée avec succès ou existe déjà.\n";
} else {
    die("Erreur lors de la création de la base de données : " . $conn->error);
}

// Sélection de la base de données
$conn->select_db($banco);

// Lecture du fichier SQL et exécution des instructions pour créer les tables
$query = file_get_contents('config/cite_db.sql');
if ($conn->multi_query($query)) {
    echo "La structure de la base de données a été importée avec succès.\n";
    do {
        // Utilisé pour lire et ignorer les résultats afin de passer à la requête suivante
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
} else {
    die("Erreur lors de l'importation de la structure de la base de données : " . $conn->error);
}

// Fermeture de la connexion à la base de données
$conn->close();
