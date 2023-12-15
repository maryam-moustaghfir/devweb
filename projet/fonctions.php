<?php

/* Connexion à MariaDB */
function connexion()
{
    try 
    {
        // Connexion à la base de données
        $db = new mysqli('localhost','jeux-videos','IsImA_2023/%','jeux-videos', 3307);
        $db->query('SET NAMES UTF8');
        return $db;   
    } 
    catch (Exception $e) // Gèrer les exceptions
    {
        echo 'Erreur de connexion: ' . $e->getMessage(); //affichage de l'erreur 
        return null;
    }
}

/* Récupération des articles d'une famille donnée */
function obtenirArticlesCategorie($categorie_id,$db) 
{
    $sql = "SELECT id,id_categorie, libelle, prix_ttc, detail,image FROM article WHERE id_categorie = $categorie_id";
    $result = $db->query($sql); // exécution de la requête
    if ($result === false) // Vérification de la bonne exécution de la requête
    {
        echo 'Erreur SQL : ' . $db->error;
        return null; // Retourne null en cas d'erreur
    }
    // Récupèration de tous les articles de la catégorie
    $articles = array();
    while ($row = $result->fetch_assoc()) 
    {
        $articles[] = $row;
    }
    return $articles;
}

/* Affichage d'un article à partir d'un tableau d'articles */
function afficher_un_article($result)
{    
    echo '<div class= "articles-container">';
    foreach ($result as $article) // Affichage des données de l'article + son bouton commander 
    {
        echo '<div class="forme-container">'; 
        $imagePath = 'img_articles/' . $article['image'];
        echo '<img src="' . $imagePath . '" alt="Image de l\'article" >';// Affichage de l'image de l'article
        echo '<h1>' . $article['libelle'] . '</h1>'; // Affichage du libelle de l'article
        echo '<h3 >' . $article['detail'] .'...'. '</h3>'; // Affichage du detail de l'article
        echo '<p >' . $article['prix_ttc'] . ' €</p>'; // Affichage du prix TTC de l'article
        echo '<form method="post" action="commander.php">';
        echo "<input type='hidden' name='article_id' value='{$article['id']}'>";// Champ caché pour transporter l'id de l'article
        echo '<button class="bouton" type="submit" >commander</button>';// Bouton commander
        echo '</form>';
        echo '</div>';
    }
    echo '<div><a href="./index.php"  class="bouton">retour</a></div>'; // Bouton retour
    echo '</div>';             
}

/* Affichage des articles */
function afficher_articles($db,$categorie_id)
{
    // Récupération des articles de la famille 
    $articles = obtenirArticlesCategorie($categorie_id,$db);
    if ($articles) // Vérification si des articles ont été trouvés
    {
        afficher_un_article($articles);
    } 
}

/* Affichage des familles  */
function afficher_famille($db)
{
    $sql = 'SELECT id, libelle, image, ordre_affichage FROM categorie ORDER BY ordre_affichage';// La requête
    $result = $db->query($sql) or die('Erreur SQL : ' . mysqli_error($db));// Exécution de la requête
    $count = 0; // Compteur concus pour mettre les familles dans le bloc(1-->sup/ 2-->inf) correspondant 
    echo '<div class="bloc1">';
    while ($data = $result->fetch_assoc()) 
    {
        echo "<a href='./index.php?famille=$data[id]'>"; //Lien vers les articles de la famille correspondante
        echo '<div  class="cercle">';
        $imagePath = 'img_categories/' . $data['image'];
        echo '<img src="' . $imagePath . '" alt="Image de l\'article" >'; // L'image représentative de la famille 
        if (in_array(strtolower($data['libelle'][0]), ['h', 'a','e','i','o','u','y'])) // Gestion de l'apostrophe
        {
            echo '<h3>'.'Jeux d\'' . $data['libelle'].'</h3>'; // Le cas de voyelle ou d'un 'h' muet 
        } 
        else 
        {
            echo '<h3>'.'Jeux de ' . $data['libelle'].'</h3>';
        }
        echo '</div>';
        echo '</a>';
        $count++;
        if($count == 3 ) // 3 familles sont mises dans le Bloc1
        {
            echo '</div>'; // Fermeture du la divsion de classe Bloc1 
            echo '<div class="bloc2">';// Ouverture de la division de classe Bloc2
        }                         
    }
    echo '</div>';
}

/* Gerer l'affichage de la division contenu */
function afficher_familles_articles($db)
{
    if (isset($_GET['famille'])) //si le paramètre 'famille' est présent dans l'URL
    {
        $categorie_id = intval($_GET['famille']);
        afficher_articles($db,$categorie_id); //affichage des articles correspondants           
    }
    else
    {
        afficher_famille($db); //affichage des familles              
    }
}

/* Gerer l'affichage des articles et du total dans le panier*/
function gestion_panier($db)
{                    
    $sql = 'SELECT libelle,quantite,article.prix_ttc FROM panier_article join article on panier_article.id_article = article.id';
    $result = $db->query($sql) or die('Erreur SQL : ' . mysqli_error($db));// exécution de la requête
    $total = 0; // Initialisation du total
    while($data = $result->fetch_assoc()) // Lire chaque enregistrement 
    {
        
        $total = $total + afficher_article_dans_panier($data); //Affichage de l'article dans le panier + MAJ $total
    }
    if ($total > 0)
    {
        afficher_total_dans_panier($total);// Affichage du prix total
    }                    
}
function afficher_article_dans_panier($data)
{
    echo '<b> <div class="libelle">';
    echo $data['libelle']; // Affichage du libelle d
    echo '</b> </div>';
    $total_article = $data['quantite'] * $data['prix_ttc']; // Calcul du prix total de l'article
    echo '<b><div class="droite">';
    echo $data['quantite'].' x '.$data['prix_ttc']. ' = '.$total_article . '€'; //Expression de calcul du prix total
    echo '</div></b>';
    return $total_article; // Retourner le prix total de l'article en se basant sur la quantité
}
function afficher_total_dans_panier($total)
{
    echo '<hr>';
    echo '<b><div class="droite">';
    echo ' TOTAL : ' . $total . '€'; // Affichage de la totalité des prix des articles 
    echo '</div></b>';
    echo '<form class="panier_titre" method="post" action="">';
    echo '<button class="bouton" type="submit" name="vider_panier" value="panier_vide">Vider le panier</button>';
    echo '</form>';

}

// FONCTIONS SPECIALLE
function vider_panier($db)
{
    try 
    {
        $sql = "DELETE FROM panier_article where panier_article.id_panier = 1";//La requête
        $db->query($sql); // Exécution de la requête
        header("Refresh:0");// Actualisation de la page actuelle 
        exit();
    } 
    catch (Exception $e) // Gestion des erreurs de la base de données
    {
        echo "Error de suppression de la table panier_article: " . $e->getMessage();
        exit();
    }
}

function recuperer_taux($idtva,$db)
{
    $sql_tva = "SELECT taux FROM tva WHERE id =$idtva ";
    $result_tva = $db->query($sql_tva); 
    if ($result_tva === false) 
    {
        echo 'Erreur SQL : ' . $db->error;
        return null; // Retourne null en cas d'erreur
    }
    $row_tva = $result_tva->fetch_assoc();
    if ($row_tva) 
    {
        $taux=$row_tva['taux'];
    }
    return $taux;

}
function calcul_prix_ht($prix_ttc,$idtva,$db)
{
    $taux= recuperer_taux($idtva,$db);
    return number_format($prix_ttc - ($taux * $prix_ttc)/100,2);//calcule de prix hors taxe
}

function incrementer_quantite($article_id,$db)
{
    
    $quantite = calcul_quantite($article_id,$db)['quantite'];
    $quantite = $quantite + 1; //

    // Préparer la requête SQL UPDATE
    $sql_update = "UPDATE panier_article SET quantite = ? WHERE id_article = ?";

    // Préparer la requête
    if ($stmt = $db->prepare($sql_update)) 
    {
        // Lier les paramètres
        $stmt->bind_param("ii", $quantite, $article_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Quantité mise à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour de la quantité : " . $stmt->error;
        }

        // Fermer la requête préparée
        $stmt->close();
    } 
    else
    {
        echo "Erreur de préparation de la requête SQL.";
    }


}
function insertion_premiere_fois($article_id,$idtva,$prix_ttc,$db)
{
    try
    {
        $prix_ht = calcul_prix_ht($prix_ttc,$idtva,$db);
        $taux= recuperer_taux($idtva,$db);
        $insert_query = "INSERT INTO panier_article (id_panier, id_article, quantite, prix_ht, prix_tva, prix_ttc) VALUES (1, $article_id, 1, $prix_ht, $taux, $prix_ttc)";
        $db->query($insert_query);
    }
    catch(Exception $e)
    {
        echo "Error de suppression de la table panier_article: " . $e->getMessage();
        exit();
    }

}
function calcul_quantite($article_id,$db)
{
    $sql_panierarticle = "SELECT quantite FROM panier_article WHERE id_article = $article_id and id_panier=1";
    $result_panierarticle = $db->query($sql_panierarticle);
                    
                  
    if ($result_panierarticle === false) 
    {
        echo 'Erreur SQL : ' . $db->error;
        return null; // Retourne null en cas d'erreur
    }
    return $result_panierarticle->fetch_assoc();

}





























if (isset($_POST['vider_panier'] ))
{
    vider_panier(connexion());               
}
?>