<?php

// index.php est le fichier point d'entrée unique de notre site
// => quelle que soit la page demandée, on passe toujours et 
// uniquement par index.php
// Avantage, on factorise une partie du code qui est nécessaire à 
// toutes les pages, par exemple l'inclusion de la classe Article 
// ou l'inclusion des templates header et footer

// ===========================================================
// Inclusion des fichiers nécessaires
// ===========================================================

// permet d'utiliser la librairie kint
require __DIR__ . '/kint.phar';
require __DIR__ . '/inc/classes/DBData.php';
require __DIR__ . '/inc/classes/Article.php';
require __DIR__ . '/inc/classes/Category.php';
require __DIR__ . '/inc/classes/Author.php';

$dbData = new DBData();

// var_dump(__DIR__);

// ===========================================================
// Récupération des données nécessaires à toutes les pages
// du site (pour le moment on ne récupère que la page à
// afficher, mais d'autres données viendront se rajouter
// plus tard)
// ===========================================================

// -----------------------------------------------------
// Récupération de la page à afficher
// -----------------------------------------------------

// Par défaut, on considère qu'on affichera la page d'accueil
$pageToDisplay = 'home';
// Mais si un paramètre 'page' est présent dans l'URL, c'est
// qu'on veut afficher une autre page
if (isset($_GET['page']) && $_GET['page'] !== '') {
   $pageToDisplay = $_GET['page'];
}

// ===========================================================
// Chaque page nécessite une préparation différente car elle
// affiche des informations différentes
// ===========================================================

// ------------------
// Page d'Accueil
// ------------------
if ($pageToDisplay === 'home') {
    // Récupération du tableau Php contenant la liste
    // d'objets Article
    $articlesList = $dbData->getAllArticles();
    // d() => un var_dump amélioré
    // d($articlesList); => permet d'afficher la variable $articlesList avec un interface sympa :)
    // d($GLOBALS); => permet d'afficher toutes les GLOBALS avec un interface sympa :)
}
// ------------------
// Page Article
// ------------------
else if ($pageToDisplay === 'article') {
    // Récupération du tableau Php contenant la liste
    // d'objets Article
    $articlesList = $dbData->getAllArticles();
    // On souhaite récupérer uniquement les données de l'article
    // à afficher
    $articleId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    // filter_input renvoie null si la paramètre n'existe pas
    // et false si le filtre de validation échoue
    // On s'assure donc de ne pas tomber ni sur false, ni sur null
    if ($articleId !== false && $articleId !== null) {
        $articleToDisplay = $articlesList[$articleId];
    } 
    // Si l'id n'est pas fourni, on affiche la page d'accueil
    // plutôt que d'avoir un message d'erreur
    else {
        $pageToDisplay = 'home';
    }
}
// ------------------
// Page Auteur
// ------------------
else if ($pageToDisplay === 'author') {

    $authorsList = $dbData->getAllAuthors();

    $authorId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($authorId !== false && $authorId !== null) {
        $authorToDisplay = $authorsList[$authorId];

        // on peut créer un tableau vide, qu'on remplira avec les articles de l'auteur, au fur et à mesure
        $articlesFromAuthor = [];

        // pour chaque article du site
        foreach ($dataArticlesList as $currentId => $currentArticle) {
            // si le nom de sa catégorie correspond à l'auteur demandée
            if ($currentArticle->author == $authorToDisplay->name) {
                // alors ajouter l'article dans le tableau
                $articlesFromAuthor[$currentId] = $currentArticle;
            }
        }

    } 

    else {
        $pageToDisplay = 'home';
    }

    
}
// ------------------
// Page Catégorie
// ------------------
else if ($pageToDisplay === 'category') {

    $categoriesList = $dbData->getAllCategories();

    $categoryId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($categoryId !== false && $categoryId !== null) {
        $categoryToDisplay = $categoriesList[$categoryId];

        // on peut créer un tableau vide, qu'on remplira avec les articles de la catégorie, au fur et à mesure
        $articlesFromCategory = [];

        // pour chaque article du site
        foreach ($dataArticlesList as $currentId => $currentArticle) {
            // si le nom de sa catégorie correspond à la catégorie demandée
            if ($currentArticle->category == $categoryToDisplay->name) {
                // alors ajouter l'article dans le tableau
                $articlesFromCategory[$currentId] = $currentArticle;
            }
        }

    } 

    else {
        $pageToDisplay = 'home';
    }


}

// ===========================================================
// Affichage
// ===========================================================

// Rappel : les variables définies dans index.php, et dans les 
// fichiers inclus par index.php (inc/data_from_db.php par exemple)
// seront accessibles dans le code des templates inclus
// ci-dessous

require __DIR__.'/inc/templates/header.tpl.php';
require __DIR__.'/inc/templates/' . $pageToDisplay . '.tpl.php';
require __DIR__.'/inc/templates/footer.tpl.php';