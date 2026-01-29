<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= htmlspecialchars($data['quizz']->getTitle()) ?></title>
</head>
<body>

<main class="container">

    <article>

        <header>
            <h1><?= htmlspecialchars($data['quizz']->getTitle()) ?></h1>
            <p>
                <small>
                    Créé le <?= $data['quizz']->getCreatedAt()->format('d/m/Y H:i') ?>
                    <?php if ($data['quizz']->getUpdatedAt()): ?>
                        • Mis à jour le <?= $data['quizz']->getUpdatedAt()->format('d/m/Y H:i') ?>
                    <?php endif; ?>
                </small>
            </p>
        </header>

        <p>
            <?= nl2br(htmlspecialchars($data['quizz']->getDescription())) ?>
        </p>

        <section>
            <h3>Auteur</h3>
            <p><?= htmlspecialchars($data['quizz']->getAuthor()->getPseudo()) ?></p>
        </section>

        <?php if (!empty($data['quizz']->getCategories())): ?>
            <section>
                <h3>Catégories</h3>
                <ul>
                    <?php foreach ($data['quizz']->getCategories() as $category): ?>
                        <li><?= htmlspecialchars($category->getName()) ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if ($data['quizz']->getMedia()): ?>
            <section>
                <h3>Média</h3>
                <img
                    src=<?= "/assets/img/" . $data['quizz']->getMedia()->getUrl() ?>
                    alt="<?= $data['quizz']->getMedia()->getAlt() ?>">
            </section>
        <?php endif; ?>

        <footer>
            <nav>
                <a href="/quizz/all" role="button" class="secondary">Retour</a>
                <a href="/quizz/edit/<?= $data['quizz']->getId() ?>" role="button">
                    Modifier
                </a>
            </nav>
        </footer>

    </article>

</main>

</body>
</html>
