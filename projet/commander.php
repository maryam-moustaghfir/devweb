<?php
//conxion
$db = new mysqli('localhost','jeux-videos','IsImA_2023/%','jeux-videos', 3307);
if (isset($_POST['article_id'])) 
{
    $article_id = $_POST['article_id'];
    $sqlarticle = "SELECT  libelle, prix_ttc,id_tva,id_categorie FROM article WHERE id = $article_id";
    $result = $db->query($sqlarticle);
                    
                        // Vérifie si la requête s'est bien exécutée
    if ($result === false) 
    {
        echo 'Erreur SQL : ' . $db->error;
        return null; // Retourne null en cas d'erreur
    }
    $row = $result->fetch_assoc();

// Vérifie si des résultats ont été trouvés
    if ($row) 
    {
        $libelle = $row['libelle'];
        $prix_ttc = $row['prix_ttc'];
        $idtva=$row['id_tva'];
        $id_categorie =$row['id_categorie'];
    }
    
    $sqltva = "SELECT taux FROM tva WHERE id =$idtva ";
    $result2 = $db->query($sqltva); 
    if ($result2 === false) 
    {
        echo 'Erreur SQL : ' . $db->error;
        return null; // Retourne null en cas d'erreur
    }
    $row2 = $result2->fetch_assoc();
    if ($row2) 
    {
        $taux=$row2['taux'];
    }
    $prix_ht = number_format($prix_ttc - ($taux * $prix_ttc)/100,2);//calcule de prix hors taxe
    
    //inserer dans la table s'il n'existe pas
    

    

    $sql_qte = "SELECT quantite FROM panier_article WHERE id_article = $article_id and id_panier=1";
    $result3 = $db->query($sql_qte);
                    
                  
    if ($result3 === false) 
    {
        echo 'Erreur SQL : ' . $db->error;
        return null; // Retourne null en cas d'erreur
    }
    $row3 = $result3->fetch_assoc();


    if ($row3) {
        $quantite = $row3['quantite'];
        $quantite = $quantite + 1;
    
        // Préparer la requête SQL UPDATE
        $sqlupdate = "UPDATE panier_article SET quantite = ? WHERE id_article = ?";
    
        // Préparer la requête
        if ($stmt = $db->prepare($sqlupdate)) {
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
        } else {
            echo "Erreur de préparation de la requête SQL.";
        }
    }
    
    else
    {
        $insert_query = "INSERT INTO panier_article (id_panier, id_article, quantite, prix_ht, prix_tva, prix_ttc) VALUES (1, $article_id, 1, $prix_ht, $taux, $prix_ttc)";

        // Exécuter la requête
        if ($db->query($insert_query) === TRUE) {
            echo "Enregistrement ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout de l'enregistrement : " . $db->error;
        }
        
    }
    header("Location: index.php?famille=$id_categorie");
    exit();

}
?>

