<?php

date_default_timezone_set('Europe/Paris');

session_start();

//définir la racine du projet
define('PROJECT_ROOT', dirname(__DIR__));

include '../vendor/autoload.php';

//Import des ressources
use Dotenv\Dotenv;

//Import du fichier .env
$dotenv = Dotenv::createImmutable("../");
$dotenv->load();

// import librairie router
use Mithridatem\Routing\Route;
use Mithridatem\Routing\Router;
use Mithridatem\Routing\Exception\RouteNotFoundException;
use Mithridatem\Routing\Exception\UnauthorizedException;

/*if (isset($_SESSION["connected"])) {
    echo $_SESSION["user"]["id"] . "<br>";
    echo $_SESSION["user"]["pseudo"] . "<br>";
    echo $_SESSION["user"]["email"] . "<br>";
    echo $_SESSION["user"]["roles"];
}*/

$router = new Router();
$router->map(Route::controller('GET', '/', App\Controller\HomeController::class, 'index'));
$router->map(Route::controller('GET', '/login', App\Controller\RegisterController::class, 'login'));
$router->map(Route::controller('POST', '/login', App\Controller\RegisterController::class, 'login'));
$router->map(Route::controller('GET', '/register', App\Controller\RegisterController::class, 'register'));
$router->map(Route::controller('POST', '/register', App\Controller\RegisterController::class, 'register'));
$router->map(Route::controller('GET', '/profil', App\Controller\RegisterController::class, 'profil'));
$router->map(Route::controller('GET', '/category/add', App\Controller\CategoryController::class, 'addCategorie'));
$router->map(Route::controller('POST', '/category/add', App\Controller\CategoryController::class, 'addCategorie'));
$router->map(Route::controller('GET', '/category/all', App\Controller\CategoryController::class, 'showAllCategories'));
$router->map(Route::controller('GET', '/quizz/add', App\Controller\QuizzController::class, 'addQuizz'));
$router->map(Route::controller('POST', '/quizz/add', App\Controller\QuizzController::class, 'addQuizz'));
$router->map(Route::controller('GET', '/quizz/one/{id}', App\Controller\QuizzController::class, 'getOne'));
$router->map(Route::controller('GET', '/quizz/all', App\Controller\QuizzController::class, 'getAll'));
$router->map(Route::controller('GET', '/logout', App\Controller\RegisterController::class, 'logout'));
try  {
    $router->dispatch();
} catch(RouteNotFoundException $re) {
    echo $re->getMessage();
} catch(UnauthorizedException $ue) {
    echo $ue->getMessage();
}