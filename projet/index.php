<?php
// Active le mode d'exception pour MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try 
{
    // Connexion à MariaDB
    $db = new mysqli('localhost','jeux-videos','IsImA_2023/%','jeux-videos', 3307);
    $db->query('SET NAMES UTF8');   
} catch (Exception $e) 
{
    // Gère les exceptions, affiche l'erreur ou effectue d'autres actions nécessaires
    echo 'Erreur : ' . $e->getMessage();
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
       <div class="maPage"> 
            <div class="titre">
                <img src="./img_site/icone-site.gif" alt="image du titre">
                <h3>Jeux video</h3>
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
                    function obtenirArticlesCategorie($categorie_id) 
                    {
                        $db = new mysqli('localhost','jeux-videos','IsImA_2023/%','jeux-videos', 3307);
                        $sql = "SELECT id_categorie, libelle, prix_ttc, detail, image FROM article WHERE id_categorie = $categorie_id";
                        $result = $db->query($sql);
                    
                        // Vérifie si la requête s'est bien exécutée
                        if ($result === false) 
                        {
                            echo 'Erreur SQL : ' . $db->error;
                            return null; // Retourne null en cas d'erreur
                        }
                    
                        // Récupère tous les articles de la catégorie
                        $articles = array();
                        while ($row = $result->fetch_assoc()) 
                        {
                            $articles[] = $row;
                        }
                    
                        return $articles;
                    }
                    $categorie_id = isset($_GET['famille']) ? intval($_GET['famille']) : 0;

                    // Appel d'une fonction pour obtenir tous les articles de la catégorie
                    $articles = obtenirArticlesCategorie($categorie_id);
        
                    // Vérifie si des articles ont été trouvés
                    if ($articles) 
                    {
                        echo '<div class= "articles-container">';
                        // Affiche chaque article
                        foreach ($articles as $article) 
                        {
                            echo '<div class="forme-container">'; //moustatil
                            $imagePath = 'img_articles/' . $article['image'];
                            echo '<img src="' . $imagePath . '" alt="Image de l\'article" >';
                            echo '<h1>' . $article['libelle'] . '</h1>';
                            echo '<h3 >' . $article['detail'] .'...'. '</h3>';
                            echo '<p >' . $article['prix_ttc'] . ' €</p>';
                            echo '<button class="bouton">'.'commander'.'</button>';
                            echo '</div>';
                        }
                        echo '</div>'; // Fermez le conteneur de l'article
        
                    } 
        
                // Vérifier si la famille est présent dans l'URL-----------------------------------------------
                /*if (isset($_GET['famille'])) 
                {
                    // Récupérer la valeur de la de famille depuis l'URL
                    $famille = $_GET['famille'];
                
                    // Utiliser l'ID de famille pour obtenir les résultats souhaités (remplacez cette étape par votre propre logique)
                    $sql = "SELECT libelle FROM article WHERE id_categorie= $famille"; 
                    $resultats = $db->query($sql);
                
                
                    // Afficher les résultats
                    if ($resultats !== null) 
                    {
                        while ($data = $resultats->fetch_assoc()) 
                        {
                            // Affiche les données de chaque enregistrement
                            echo " ". $data['libelle'] . " -";
                        }
                    } 
                    else {
                        echo "Aucun résultat trouvé pour la famille  $famille.";
                    }
                }*/
                
                ?>
            </div>
            <div class="panier">
                <div class="panier-container">
                    <div class="titrepanier">
                        <img src='./img_site/caddie.gif'>
                        <h3>votre panier</h3>
                    </div>
                </div>
                
            </div>
        </div>
    </body>
</html>

<?php
    if ($db) 
    {
        $db->close();
    }
?>