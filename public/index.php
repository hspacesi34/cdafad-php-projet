<?php

date_default_timezone_set('Europe/Paris');

session_start();

//gérer les routes

include '../vendor/autoload.php';
//Import des ressources

use App\Controller\CategoryController;
use Dotenv\Dotenv;

//Import du fichier .env
$dotenv = Dotenv::createImmutable("../");
$dotenv->load();

//import des controllers
use App\Controller\HomeController;
use App\Controller\QuizzController;
use App\Controller\RegisterController;

//instancier les controllers
$homeController = new HomeController();
$registerController = new RegisterController();
$categoryController = new CategoryController();
$quizzController = new QuizzController();

//Analyse de l'URL avec parse_url() et retourne ses composants
$url = parse_url($_SERVER['REQUEST_URI']);
//test soit l'url a une route sinon on renvoi à la racine
$path = isset($url['path']) ? $url['path'] : '/';

//Comparer avec la liste d'url :
switch ($path) {
    case '/':
        $homeController->index();
        break;
    case '/login':
        $registerController->login();
        break;
    case '/register':
        $registerController->register();
        break;
    case '/logout':
        $registerController->logout();
        break;
    case '/category/add':
        $categoryController->addCategory();
        break;
    case '/category/all':
        $categoryController->showAllCategories();
        break;
    case '/quizz/add':
        $quizzController->addQuizz();
        break;
    default:
        echo "erreur 404";
        break;
}

/*if (isset($_SESSION["connected"])) {
    echo $_SESSION["user"]["id"] . "<br>";
    echo $_SESSION["user"]["pseudo"] . "<br>";
    echo $_SESSION["user"]["email"] . "<br>";
    echo $_SESSION["user"]["roles"];
}*/