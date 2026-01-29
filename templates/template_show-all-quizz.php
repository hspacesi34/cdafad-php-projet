<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>

<main class="container">

    <header>
        <h1><?= htmlspecialchars($title) ?></h1>
    </header>

    <?php if (empty($data['listQuizz'])): ?>
        <p>Aucun quizz disponible pour le moment.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($data['listQuizz'] as $quizz): ?>
                <article>
                    <h3><?= htmlspecialchars($quizz->title) ?></h3>

                    <p>
                        <?= nl2br(htmlspecialchars($quizz->description)) ?>
                    </p>

                    <small>
                        Créé le :
                        <?php if ($quizz->createdAt instanceof DateTimeImmutable): ?>
                            <?= $quizz->createdAt->format('d/m/Y') ?>
                        <?php else: ?>
                            <?= htmlspecialchars($quizz->createdAt) ?>
                        <?php endif; ?>
                    </small>

                    <footer>
                        <a href="/quizz/one/<?= (int) $quizz->id ?>" role="button">
                            Voir le quizz
                        </a>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

</body>
</html>
