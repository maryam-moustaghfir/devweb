<?php
function connexion()
{
    try 
    {
        // Connexion à MariaDB
        $db = new mysqli('localhost','jeux-videos','IsImA_2023/%','jeux-videos', 3307);
        $db->query('SET NAMES UTF8');
        return $db;   
    } 
    catch (Exception $e) 
    {
        // Gère les exceptions, affiche l'erreur ou effectue d'autres actions nécessaires
        echo 'Erreur : ' . $e->getMessage();
        return null;
    }

}


function obtenirArticlesCategorie($categorie_id,$db) 
{
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

function afficher_famille_article($db)
{
    if (isset($_GET['famille'])) 
    {
        afficher_article($db);                
    }
    else
    {
        afficher_famille($db);                 
    }
}

function afficher_article($db)
{
    //affichages des articles 
    $categorie_id = isset($_GET['famille']) ? intval($_GET['famille']) : 0;

    // Appel d'une fonction pour obtenir tous les articles de la catégorie
    $articles = obtenirArticlesCategorie($categorie_id,$db);

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
            echo '<form method="post" action="commander.php">';
            echo "<input type='hidden' name='article_id' value='{$article['id']}'>";
            echo '<button class="bouton" type="submit" >commander</button>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';             
    }
}
function afficher_famille($db)
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
function gestion_panier($db)
{                    
    $sqlpanier = 'SELECT libelle,quantite,article.prix_ttc FROM panier_article join article on panier_article.id_article = article.id';
    $resultpanier = $db->query($sqlpanier);
    if ($resultpanier === false) 
    {
        echo 'Erreur SQL : ' . $db->error;
    }
    $total = 0;
    while($data = $resultpanier->fetch_assoc())
    {
        echo '<b> <div style="margin-left:10px">';
        echo $data['libelle'];
        echo '</b> </div>';
        $total_article = $data['quantite'] * $data['prix_ttc'];
        $total = $total +$total_article;
        echo '<b><div  style="text-align: right;margin-right: 10px">';
        echo $data['quantite'].' x '.$data['prix_ttc']. ' = '.$total_article . '€';
        echo '</div></b>';   
    }
    if ($total > 0)
    {
        echo '<hr>';
        echo '<b><div  style="text-align: right;margin-right: 10px">';
        echo ' TOTAL : ' . $total . '€';
        echo '</div></b>';
        echo '<form class="panier_titre" method="post" action="">';
        echo '<button class="bouton" type="submit" name="vider_panier" value="panier_vide">Vider le panier</button>';
        echo '</form>';
    }                    
}

// FONCTIONS SPECIALLE
function vider_panier($db)
{
    try 
    {
        $sql_panarticle = "DELETE FROM panier_article where panier_article.id_panier = 1";
        $db->query($sql_panarticle);
        //actualiser la page actuelle 
        header("Refresh:0");
        exit();
    } 
    catch (Exception $e) 
    {
        // Gestion des erreurs de la base de données
        echo "Error de suppression de la table panier_article: " . $e->getMessage();
        exit();
    }
}

if (isset($_POST['vider_panier'] ))
{
    vider_panier(connexion());               
}
?>