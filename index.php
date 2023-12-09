<html>
	<head>
		<!-- titre de la fenêtre -->
		<title>Titre</title>
		<!-- précise l'encodage au navigateur (gestion des accents, ...) -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Feuille de style -->
		<link rel="stylesheet" type="text/css" href="styles.css">
		<!-- Inibe la grande largeur sur mobile : évite que le mobile présente un écran large et qu'il faille zoomer -->
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0" />
		<!-- icône de la page -->
		<!-- <link rel="icon" href="img/icone-site.gif" /> -->
	</head>
	<body>
			<div class="titre"><img src="./img_site/icone-site.gif" width="200px"> Jeux video </div>
			<div class="authentification">authentification </div>
			<div class="contenu">contenu</div>
			<div class="panier">panier</div>
    </body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Achat de jeux vidéos</title>
    <link rel="icon" type="image/gif" href=" img/img_site/icone-site.gif">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link href="style/index.css" rel="stylesheet" />
</head>
<body>
    <div class='page'>
        <div class='titre'>
            <a href='http://projet/'>
                <img src="img/img_site/icone-site.gif" alt="Icone du site"/>
                <h1>Jeux vidéos</h1>
            </a>
        </div>
        <div class='authentification'>
            <form>
                <div class='case_bleu'>
                    <label for="email"><p>Adresse email</p></label>
                    <input type="email" name="email" /></br>
                    <label for="password"><p>Mot de passe</p></label>
                    <input type="password" name="password" />
                </div>
            </form>
            <div class='boutons-container'>
                <div class='bouton'>S'inscrire</div>
                <div class='bouton'>Connexion</div>
            </div>
        </div>
        <div class='contenu'>
            <?php 
            include 'article.php';
            ?>
        </div>
        <div class='panier'>
            <div class='sous_panier'>
                <h3><img src="img/img_site/caddie.gif" /> Votre panier</h3>
                <hr>
                <?php
                include 'panier.php';
                ?>
                
            </div>
        </div>
        <div class='pied_de_page'></div>
    </div>
</body>
</html>