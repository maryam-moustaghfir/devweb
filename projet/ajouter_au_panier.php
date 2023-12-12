<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['article_id'])) {
    // Récupérez l'ID de l'article depuis le formulaire
    $articleId = $_POST['article_id'];

    // Initialiser le panier s'il n'existe pas encore
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Ajoutez l'article au panier s'il n'est pas déjà présent
    if (!in_array($articleId, $_SESSION['panier'])) {
        $_SESSION['panier'][] = $articleId;
    }

    // Redirigez vers la page principale
    header('Location: index.php');
    exit();
}
?>
