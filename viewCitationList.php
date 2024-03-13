<?php
function load($class)
{
    include("Entity/" . $class . ".class.php");
}

spl_autoload_register("load");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $auteurManager = new auteurManager();
    $citationManager = new CitationManager();

    $citations = $citationManager->readAll(false, -1);
    $auteurs = $auteurManager->readAll();
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Citation List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.html'; ?>
    <h1>View Citations</h1>
    <?php if (!empty($auteurs)) : ?>
        <table frame="above">
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Citations</th>
                    <th>Quote</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auteurs as $auteur) : ?>
                    <tr>
                        <td><?= $auteur->getNomComplet() ?></td>
                        <td>
                            <?php

                            $_citations = $auteur->getCitations();
                            echo "" . sizeof($_citations);
                            ?></td>
                        <td>
                            <div class="quote-container">
                                <?php foreach ($citationManager->readAll(false, -1, $auteur->getId()) as $c) : ?>
                                    <div class="quote-line">
                                        <span class="quote-text"><?= htmlspecialchars($c->getTexte()) ?></span>
                                        <a href="https://example.com" class="linkButton">Voir</a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No auteurs found.</p>
    <?php endif; ?>
</body>

</html>