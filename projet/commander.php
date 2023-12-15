<?php
require_once('fonctions.php');
$db = connexion();
if (isset($_POST['article_id'])) 
{
    inserer_article($_POST['article_id'],$db);
}

function inserer_article($article_id,$db)
{
    $sql_article = "SELECT  libelle, prix_ttc,id_tva,id_categorie FROM article WHERE id = $article_id";
    $result_article = $db->query($sql_article);
                    
    // Vérifie si la requête s'est bien exécutée
    if ($result_article === false) 
    {
        echo 'Erreur SQL : ' . $db->error;
        return null; // Retourne null en cas d'erreur
    }
    $row_article = $result_article->fetch_assoc();

// Vérifie si des résultats ont été trouvés
    if ($row_article) 
    {
        //$libelle = $row_article['libelle'];
        $prix_ttc = $row_article['prix_ttc'];
        $idtva=$row_article['id_tva'];
        $id_categorie =$row_article['id_categorie'];
    }    
    //inserer dans la table s'il n'existe pas
    //$prix_ht =calcul_prix_ht($prix_ttc,$idtva,$db);
    if (calcul_quantite($article_id,$db))
    {
        incrementer_quantite($article_id,$db);    
    }
    else
    {
        insertion_premiere_fois($article_id,$idtva,$prix_ttc,$db);  
    }
    header("Location: index.php?famille=$id_categorie");
    exit();
}
?>