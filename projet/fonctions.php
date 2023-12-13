/*
                    <?php
                    //$db = new mysqli('localhost','jeux-videos','IsImA_2023/%','jeux-videos', 3307);
                    $sqlpanier = 'SELECT libelle,quantite,article.prix_ttc FROM panier_article join article on panier_article.id_article = article.id';
                    $resultpanier = $db->query($sqlpanier);
                    if ($resultpanier === false) 
                    {
                        echo 'Erreur SQL : ' . $db->error;
                        return null; // Retourne null en cas d'erreur
                    }
                    while($data = $resultpanier->fetch_assoc())
                    {
                        echo $data['libelle'];
                    }
                    ?>
                    */