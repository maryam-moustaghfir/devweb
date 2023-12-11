<?php
require('fonctions.php');
$connexion = connexion();
?>

<html>
	<head>
		<title>Titre</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0" />
	</head>
	<body>

	    <div class="titre">
            <img class="imageTitre" src="./img_site/icone-site.gif" alt="image du titre">
            Jeux video
        </div>
		<div class="authentification">
            <form>
                <div class="authBloc">
                    <div class="container-left1">
                        <label for="email">adresse mail</label><br>
                    </div>
                    <div class="container-left2">
                        <input type="email" name="email" /><br>
                    </div>
                    <div class="container-left1">
                        <label for="password">mot de passe</label><br>
                    </div>
                    <div class="container-left2">
                        <input type="password" name="password" /><br>
                    </div>
                </div>
                <button class="bouton">s'inscrire</button>
                <button class="bouton">connexion</button>                    
            </form>
        </div>
        <div class="contenu">    
        <?php
        // Active le mode d'exception pour MySQLi
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            // Récupération de l'ID de la catégorie depuis l'URL
            $categorie_id = isset($_GET['famille']) ? intval($_GET['famille']) : 0;

            // Appel d'une fonction pour obtenir tous les articles de la catégorie
            $articles = obtenirArticlesCategorie($connexion, $categorie_id);

            // Vérifie si des articles ont été trouvés
            if ($articles) {
                echo '<div class="articles-container">';
                // Affiche chaque article
                foreach ($articles as $article) {
                    echo '<div class="forme-container">';

                    echo '<h1 class="libelle">' . $article['libelle'] . '</h1>';
                    echo '<div class="detail">' . $article['detail'] .'...'. '</div>';
                    echo '<p class="style-prix">' . $article['prix_ttc'] . ' €</p>';
                    $imagePath = 'img_articles/' . $article['image'];
                    echo '<img src="' . $imagePath . '" alt="Image de l\'article" class="img-article">';
                    echo '<button class="bouton">'.'commander'.'</button>';
                    echo '</div>';
                }
                echo '</div>'; // Fermez le conteneur de l'article

            } else {
                echo 'Aucun article trouvé dans cette catégorie.';
            }
        } catch (Exception $e) {
            // Gère les exceptions, affiche l'erreur ou effectue d'autres actions nécessaires
            echo 'Erreur : ' . $e->getMessage();
        } finally {
            // Ferme la connexion à MariaDB
            if ($connexion) {
                $connexion->close();
            }
        }
        ?>
        </div>
	<div class="panier">panier</div>
    </body>
</html>
