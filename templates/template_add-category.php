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
        <h1>Créer une catégorie</h1>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Saisir le nom de la catégorie">
            <input type="submit" value="Ajouter" name="submit">
        </form>
        <p><?= $data["msg"] ?? ""  ?></p>
    </main>
</body>
</html>
