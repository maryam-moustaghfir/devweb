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
		<title>Vente en ligne</title>
		<!-- précise l'encodage au navigateur (gestion des accents, ...) -->
		<meta http-equiv="Content-Type" content="text/html; charset= utf-8"/>
        <meta charset="UTF-8">
		<!-- Feuille de style -->
		<link rel="stylesheet" type="text/css" href="styles.css">
		<!-- Inibe la grande largeur sur mobile : évite que le mobile présente un écran large et qu'il faille zoomer -->
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0" />
	</head>
	<body>
       <div class="maPage"> 
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
                    function obtenirArticlesCategorie($categorie_id) 
                    {
                        $db = new mysqli('localhost','jeux-videos','IsImA_2023/%','jeux-videos', 3307);
                        $sql = "SELECT id,id_categorie, libelle, prix_ttc, detail, image FROM article WHERE id_categorie = $categorie_id";
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
                    
                    if (isset($_GET['famille']))
                    {
                        //affichages des articles 
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
                                echo '<form method="post" action="ajouter_au_panier.php">';
                                echo "<input type='hidden' name='id' value='{$article['id']}'>";
                                echo '<button class="bouton" type="submit" >commander</button>';
                                echo '</form>';
                                echo '</div>';
                            }
                            echo '</div>';             
                        }    
                        
                        
                    }
                    else
                    {
                        //page d'acceuil
                        $sqll = 'SELECT id, libelle, image, ordre_affichage FROM categorie ORDER BY ordre_affichage';
                        $resultss = $db->query($sqll);
                        $count = 0;
                        echo '<div class="bloc1">';

                        while ($data = $resultss->fetch_assoc()) 
                        {
                            echo "<a href='./index.php?famille=$data[id]'>";
                            echo '<div  class="cercle">';
                            $imagePath = 'img_categories/' . $data['image'];
                            echo '<img src="' . $imagePath . '" alt="Image de l\'article" >';
                            echo '<h3>'.'Jeux de ' . $data['libelle'].'</h3>';
                            echo '</div>';
                            echo '</a>';
                            $count++;
                            if($count==3)
                            {
                                echo '</div>';
                                echo '<div class="bloc2">';
                            }                         
                        }
                        echo '</div>';         
                    }
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