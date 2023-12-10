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
                    <label for="email" style="float:right;clear:both" >adresse mail</label>
                    <input type="email" name="email" />
                    <label for="password">mot de passe</label>
                    <input type="password" name="password" />
                </div>
                <button class="bouton">s'inscrire</button>
                <button class="bouton">connexion</button>                    
            </form >
        </div>
		<div class="contenu">contenu</div>
		<div class="panier">panier</div>
    </body>
</html>