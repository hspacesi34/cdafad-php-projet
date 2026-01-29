<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= $title ?? "" ?></title>
</head>

<body>
    <main class="container-fluid">
        <h1>Créer un quizz</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Saisir le titre du quizz">
            <textarea name="description" placeholder="Saisir la description du quizz"></textarea>
            <label for="categories">
                Catégories
                <?= $data["categoryListComponent"] ?>
            </label>
            <input type="file" name="img">
            <input type="submit" value="Ajouter" name="submit">
        </form>
        <p><?= $data["msg"] ?? ""  ?></p>
    </main>
</body>

</html>