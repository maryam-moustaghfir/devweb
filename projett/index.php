<?php
// Active le mode d'exception pour MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // 1. on se connecte à MariaDB
    $db = new mysqli('localhost', 'jeux-videos', 'IsImA_2023/%', 'jeux-videos', 3307);
    $db->query('SET NAMES UTF8');

    // 2. on exécute la requête
    $sql = 'SELECT libelle FROM article';
    $result = $db->query($sql);

    // Vérifie si la requête s'est bien exécutée
    if ($result === false) {
        throw new Exception($db->error);
    }

    // 3. on fait une boucle pour lire chaque enregistrement
    while ($data = $result->fetch_assoc()) {
        // Affiche les données de chaque enregistrement
        print_r($data);
    }
} catch (Exception $e) {
    // Gère les exceptions, affiche l'erreur ou effectue d'autres actions nécessaires
    echo 'Erreur : ' . $e->getMessage();
} finally {
    // 4. on ferme la connexion à MariaDB (dans le bloc finally pour s'assurer qu'elle est toujours fermée)
    if ($db) {
        $db->close();
    }
}
?>



<html>
	<head>
		<!-- titre de la fenêtre -->
		<title>Titre</title>
		<!-- précise l'encodage au navigateur (gestion des accents, ...) -->
		<meta http-equiv="Content-Type" content="text/html; charset= utf-8"/>
		<!-- Feuille de style -->
		<link rel="stylesheet" type="text/css" href="styles.css">
		<!-- Inibe la grande largeur sur mobile : évite que le mobile présente un écran large et qu'il faille zoomer -->
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
            </form >
        </div>
        <div class="contenu">
    
</div>





		<div class="panier">panier</div>
    </body>
</html>