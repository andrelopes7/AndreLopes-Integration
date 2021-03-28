<?php

class DBData
{

    private $pdo;

    // à l'instanciation de la classe, on se connecte à la BDD
    public function __construct()
    {
        $dsn = 'mysql:dbname=oblog;host=localhost;charset=UTF8';
        $username = 'oblog';
        $password = 'oblog';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ];

        $this->pdo = new PDO($dsn, $username, $password, $options);
    }

    // Méthode qui permet de récupérer tous les articles
    public function getAllArticles()
    {
        $dataArticlesList = [];

        $sql = '
        SELECT * FROM `post`
        ';
    
        // $this->pdo correspond à la connexion à la BDD
        $pdoStatement = $this->pdo->query($sql);
    
        $dataArticlesListAssoc = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($dataArticlesListAssoc as $currentArticle) {
            $dataArticlesList[$currentArticle['id']] = new Article(
                $currentArticle['title'],
                $currentArticle['content'],
                $currentArticle['author_id'],
                $currentArticle['published_date'],
                $currentArticle['category_id']
            ); 
        }
    
        return $dataArticlesList;
    }

    // Méhode de récupération d'un article
    public function getArticle($id)
    {
        $sql = "
        SELECT * FROM `post` WHERE `id` = '{$id}'
        ";

        $pdoStatement = $this->pdo->query($sql);

        // var_dump($pdoStatement);

        return $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode de récupération de toutes les catégories
    public function getAllCategories()
    {
        $dataCategoriesList = [];

        $sql = '
        SELECT * FROM `category`
        ';
    
        $pdoStatement = $this->pdo->query($sql);
    
        $dataCategoriesListAssoc = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($dataCategoriesListAssoc as $currentCategory) {
            $dataCategoriesList[$currentCategory['id']] = new Category(
                $currentCategory['name']
            );
        }
    
        return $dataCategoriesList;
    }

    // Méthode de récupération de tous les auteurs
    public function getAllAuthors()
    {
        $dataAuthorsList = [];

        $sql = '
        SELECT * FROM `author`
        ';

        $pdoStatement = $this->pdo->query($sql);

        // on peut faire la même chose avec un FETCH::OBJ
        $dataAuthorsListObj = $pdoStatement->fetchAll(PDO::FETCH_OBJ);

        foreach ($dataAuthorsListObj as $currentAuthor) {
            $dataAuthorsList[$currentAuthor->id] = new Author(
                $currentAuthor->name
            );
        }

        return $dataAuthorsList;
    }
}