<?php
//inclusion du fichier des fonctions php
require_once('fonctions.php');
// Activation du mode d'exception pour MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Connexion à MariaDB
$db = connexion(); 
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
		<!-- titre de la fenêtre -->
		<title>Jeux vidéos</title>
		<!-- précise l'encodage au navigateur (gestion des accents, ...) -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="UTF-8">
		<!-- Feuille de style -->
		<link rel="stylesheet" type="text/css" href="styles.css"> 
		<!-- Inibe la grande largeur sur mobile : évite que le mobile présente un écran large et qu'il faille zoomer -->
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0" />
		<!-- icône de la page -->
		<link rel="icon" href="img_site/icone-site.gif" />
	</head>
	<body>
       <div class="page">
            <div class="titre">
                <img src="./img_site/icone-site.gif" alt="image du titre">
                <a href="./index.php"><h3>Jeux vidéos</h3></a> <!-- Lien vers la page d'accueil-->
            </div>
            <div class="authentification">
                <!-- Le formulaire d'authentification-->
                <form>
                    <div class="authBloc">
                        <label for="email">adresse mail</label>
                        <input type="email" name="email"/>
                        <label for="password" >mot de passe</label>
                        <input type="password" name="password"/>
                    </div>
                    <div class="bouttons">
                        <button class="bouton">s'inscrire</button>
                        <button class="bouton">connexion</button>       
                    </div>             
                </form >
            </div>
            <div class="contenu">
                <!-- Gestion de l'affichage des familles et des articles -->
                <?php                   
                    afficher_familles_articles($db);   
                ?>
            </div>
            <div class="panier">
                <div class="minipanier">
                    <div class="panier_titre">
                        <img src="./img_site/caddie.gif">
                        <h3>votre panier</h3>
                    </div>
                    <!-- ligne de séparation --> 
                    <hr>
                    <!-- Fonction de la gestion du panier -->                     
                    <?php
                        gestion_panier($db);
                    ?>             
                </div>                
            </div>
            <div class="pied_de_page"></div>
        </div>
    </body>
</html>
<!-- Fermeture de la connexion à MariaDB --> 
<?php
mysqli_close($db);
?>