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
        
    $citations = $citationManager->readAll(true, 5);
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
    <?php if (!empty($citations)) : ?>
        <table frame="above">
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Creation Date</th>
                    <th>Quote</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($citations as $citation) : ?>
                    <tr>
                        <td><?= $citation-> getAuteur() -> getNomComplet() ?></td>
                        <td><?php echo $citation-> getCreatedAt()->format('Y-m-d'); ?></td>
                        <td> <?php echo $citation -> getTexte() ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No citations found.</p>
    <?php endif; ?>
</body>

</html>