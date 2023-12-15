<?php
//inclusion du fichier des fonctions php
require_once('fonctions.php');
// Connexion à MariaDB
$db = connexion();
if (isset($_POST['article_id'])) // Verifier la récupération de article_id par le formulaire
{
    inserer_article($_POST['article_id'],$db); // appel de la fonction inserer_article  
}
?>