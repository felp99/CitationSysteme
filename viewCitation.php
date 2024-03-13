<?php

function load($class)
{
    include("Entity/" . $class . ".class.php");
}

spl_autoload_register("load");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function test_input($data, string $champ)
{
    if (empty($data)) {
        throw new InvalidArgumentException("Les données saisies dans le champ " . $champ . " sont vides");
    }

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$auteurManager = new auteurManager();
$citationManager = new CitationManager();
$auteurs = $auteurManager->readAll();

$login = null;
$texte = "";
$fullName = null;
$login = null;
$errors = "";

try {

    $login = test_input($_POST["login"], "login");
    $texte = test_input($_POST["citation"], "citation");
    $fullName = test_input($_POST["auteur"], "auteur");
    $date = test_input($_POST["date"], "date");

    $fullName = explode(" ", $fullName);

    if (sizeof($fullName) > 3) {
        throw new InvalidArgumentException('');
    }
    
    $inserted_auteur = new Auteur($fullName[0], $fullName[1], intval($fullName[2]));

    if ($auteurManager -> exists($inserted_auteur)) {

        $auteur = $auteurManager -> readFromAttributes($inserted_auteur);
        $citation = new Citation($texte, new Datetime($date), $auteur);
        $citationManager -> create($citation);

    } else {

        $auteur_id = $auteurManager -> create($inserted_auteur);
        $auteur = $auteurManager -> read($auteur_id);
        $citation = new Citation($texte, new Datetime($date), $auteur);

        $citation = $citationManager -> create($citation);
    }
} catch (Exception $e) {
    $errors = $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.html'; ?>
    <h1>View Citation</h1>
    <table border="1" bgcolor="#ccccff" frame="above">
        <tbody>
            <tr>
                <th><label for="login">Login</label></th>
                <td><?php echo $login ?></td>
                <th>Errors</th>
            </tr>
            <tr>
                <th><label for="citation">Citation</label></th>
                <td><?php echo $texte ?></td>
                <td rowspan="5" style="background: white; color: red" name="errors_text"><?php echo $errors; ?></td>
            </tr>
            <tr>
                <th><label for="auteur">Auteur</label></th>
                <td><?php echo $auteur->getNomComplet() ?></td>
            </tr>
            <tr>
                <th><label for="date">Date</label></th>
                <td><?php echo $date ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
                    <td><?= htmlspecialchars($auteur->getNomComplet()) ?></td>
                    <td>
                    <?php 
                    
                    $_citations = $citationManager -> readAll(false, -1, $auteur -> getId());
                    echo "" . sizeof($_citations);
                    ?></td>
                    <td>
                        <ul class="quote-list">
                            <?php foreach ($_citations as $c) : ?>
                                <li><?= htmlspecialchars($c->getTexte()) ?></li>
                            <?php endforeach; ?>
                        </ul>
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





