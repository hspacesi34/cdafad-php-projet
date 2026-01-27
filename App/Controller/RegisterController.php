<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Service\SecurityService;

class RegisterController extends AbstractController
{
    private SecurityService $securityService;

    //Injection du UserRepository
    public function __construct()
    {
        $this->securityService = new SecurityService();
    }
    //Méthode pour s'inscrire
    public function register(): mixed
    {
        $data = [];
        //Test si le formulaire est submit
        if ($this->isFormSubmitted($_POST,  "submit")) {
            $data["msg"] = $this->securityService->register($_POST);
        }
        return $this->render("register", "S'inscrire", $data);
    }

    //Méthode pour se connecter
    public function login(): mixed
    {
        $data = [];
        //Test si le formulaire est submit
        if ($this->isFormSubmitted($_POST,  "submit")) {
            $data["msg"] = $this->securityService->login($_POST);
        }
        return $this->render("login", "Se connecter", $data);
    }

    //Méthode pour se connecter
    public function logout(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
