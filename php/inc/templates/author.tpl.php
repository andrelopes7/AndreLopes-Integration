<div class="container">
    <h1><?= $authorToDisplay->name; ?></h1>

    <?php foreach ($articlesFromAuthor as $currentId => $currentArticle) : ?>
        <!-- Je dispose une card: https://getbootstrap.com/docs/4.1/components/card/ -->
        <article class="card">
        <div class="card-body">
            <h2 class="card-title"><a href="index.php?page=article&id=<?= $currentId ?>"><?= $currentArticle->title ?></a></h2>
            <p class="card-text"><?= $currentArticle->content ?></p>
            <p class="infos">
            Posté par <a href="#" class="card-link"><?= $currentArticle->author ?></a> le <time datetime="<?= $currentArticle->date ?>"><?= $currentArticle->getDateFr(); ?></time> dans <a href="#"
                class="card-link">#<?= $currentArticle->category ?></a>
            </p>
        </div>
        </article>
    <?php endforeach; ?>
</div>