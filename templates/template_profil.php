<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= $title ?? "Profil utilisateur" ?></title>
</head>

<body>

    <main class="container">
        <article style="max-width: 520px; margin: auto; text-align: center;">

            <!-- Image de profil -->
            <?php if ($data['user']->getMedia() !== null): ?>
                <img
                    src="<?= '/assets/img/' . htmlspecialchars($data['user']->getMedia()->getUrl()) ?>"
                    alt="<?= htmlspecialchars($data['user']->getMedia()->getAlt()) ?>"
                    style="
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
        ">
            <?php endif; ?>


            <!-- Pseudo -->
            <h2>@<?= htmlspecialchars($data["user"]->getPseudo()) ?></h2>

            <!-- Infos -->
            <p>
                <strong><?= htmlspecialchars($data["user"]->getFirstname()) ?></strong>
                <strong><?= htmlspecialchars($data["user"]->getLastname()) ?></strong>
            </p>

            <p>
                📧 <?= htmlspecialchars($data["user"]->getEmail()) ?>
            </p>

            <!-- Actions -->
            <footer style="margin-top: 2rem;">
                <a href="/profile/edit" role="button">Modifier le profil</a>
            </footer>

        </article>
    </main>

</body>

</html>