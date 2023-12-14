<?php
require_once('fonctions.php');
// Active le mode d'exception pour MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = connexion(); 
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
		<!-- titre de la fenêtre -->
		<title>Jeux video</title>
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
                <a href="./index.php"><h3>Jeux video</h3></a>
            </div>

            <div class="authentification">
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
                <?php                   
                    afficher_famille_article($db);
                    
                ?>
            </div>
            <div class="mon_panier">
                <div class="sous_panier">
                    <div class="panier_titre">
                        <img src='./img_site/caddie.gif'>
                        <h3>votre panier</h3>
                    </div>
                    <hr>                    
                    <?php
                    gestion_panier($db);
                    ?>             
                </div>                
            </div>
            <div class='pied_de_page'></div>
        </div>
    </body>
</html>