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
            $db = new mysqli('localhost', 'jeux-videos', 'IsImA_2023/%', 'jeux-videos', 3307);
    $db->query('SET NAMES UTF8');

    // 2. on exécute la requête
    $sql = 'SELECT id, libelle, image, ordre_affichage FROM categorie';
    $result = $db->query($sql);

    // Vérifie si la requête s'est bien exécutée
    if ($result === false) {
        throw new Exception($db->error);
    }

    // 3. on fait une boucle pour lire chaque enregistrement
    // Boucle pour afficher les cercles
    $count = 0; // Compteur pour suivre le nombre de cercles
    echo '<div class="ligne-flex">'; // Début du premier conteneur flexible

    while ($data = $result->fetch_assoc()) {
        // Affiche les données de chaque enregistrement
        echo '<div class="cercle">';

        $imagePath = 'img_categories/' . $data['image'];
        echo '<img src="' . $imagePath . '" alt="Image de l\'article" class="img-categorie">';
        echo '<div class="style-categorie">'.'Jeux de ' . $data['libelle'].'</div>';

        echo '</div>';

        $count++;

        // Si nous avons affiché trois cercles, fermons le premier conteneur flexible et ouvrons le deuxième
        if ($count === 3) {
            echo '</div>'; // Fin du premier conteneur flexible
            echo '<div class="ligne-flex-center">'; // Début du deuxième conteneur flexible
        }
    }

    echo '</div>';

    echo '</div>'; // Fin du dernier conteneur flexible

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
