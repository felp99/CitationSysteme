<?php
// Définition d'une fonction pour charger automatiquement les classes au besoin
function load($class)
{
    // Inclut le fichier correspondant à la classe demandée depuis le dossier 'Entity'
    include("Entity/" . $class . ".class.php");
}

// Enregistre la fonction 'load' comme autoloader pour charger les classes automatiquement
spl_autoload_register("load");

// Configuration de PHP pour afficher toutes les erreurs
ini_set('display_errors', 1); // Affiche les erreurs d'exécution
ini_set('display_startup_errors', 1); // Affiche les erreurs au démarrage
error_reporting(E_ALL); // Rapporte toutes les erreurs PHP

$auteurManager = new AuteurManager();
$auteurs = $auteurManager->readAll();

$noms = array_map(function ($auteur) {
    return $auteur->getNomComplet();
}, $auteurs);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajout de citation</title> <!-- Titre de la page -->
    <meta charset="UTF-8"> <!-- Encodage des caractères pour la page -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.html'; ?>
    <main>
        <article>
            <header>
                <h1>Formulaire de création de citations</h1> <!-- Titre du formulaire -->
            </header>
            <!-- Début du formulaire pour ajouter une citation -->
            <form method="post" name="FrameCitation" action="viewCitation.php" onsubmit="return validateForm()">
                <!-- Tableau pour structurer le formulaire -->
                <table border="1" bgcolor="#ccccff" frame="above">
                    <tbody>
                        <!-- Champ pour entrer le login -->
                        <tr>
                            <th><label for="login">Login</label></th>
                            <td><input name="login" maxlength="64" size="32"></td>
                        </tr>
                        <!-- Champ pour entrer la citation -->
                        <tr>
                            <th><label for="citation">Citation</label></th>
                            <td><textarea cols="100" rows="5" name="citation"></textarea></td>
                        </tr>
                        <!-- Champ pour sélectionner l'auteur -->
                        <tr>
                            <th><label for="auteur">Auteur</label></th>
                            <td>
                                <input type="text" name="auteur" id="auteur" list="auteurs" required>
                                <!-- Liste des auteurs disponibles -->
                                <datalist id="auteurs">
                                    <?php
                                    // Boucle pour afficher chaque nom d'auteur comme option dans la liste
                                    for ($i = 0; $i < sizeof($noms); $i++) {
                                        echo "<option value=\"" . $noms[$i] . "\">";
                                    }
                                    ?>
                                </datalist>
                                Format "Prénom" "Nom" "Année de naissance" <br<strong>Felipe LOBATO 1999</strong>
                            </td>
                        </tr>
                        <!-- Champ pour entrer la date -->
                        <tr>
                            <th><label for="date">Date</label></th>
                            <td><input name="date" type="date" value="<?php echo date("Y-m-d"); ?>" required></td>
                        </tr>
                        <!-- Boutons pour envoyer ou réinitialiser le formulaire -->
                        <tr>
                            <td colspan="2" align="center">
                                <input name="Envoyer" value="Enregistrer la citation" type="submit">
                                <input name="Effacer" value="Annuler" type="reset">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </article>
    </main>
</body>
</html>
