<?php

namespace App\Controller;

use App\Service\CategoryService;
use App\Service\QuizzService;

class QuizzController extends AbstractController
{
    private QuizzService $quizzService;
    private CategoryService $categoryService;
    private CategoryController $categoryController;

    public function __construct()
    {
        $this->quizzService = new QuizzService();
        $this->categoryService = new CategoryService();
        $this->categoryController = new CategoryController();
    }

    public function addQuizz(): mixed
    {
        $data = [];
        $data["categoryListComponent"] = $this->categoryController->showAllCategories();
        //Test si le formulaire est submit
        if ($this->isFormSubmitted($_POST,  "submit")) {
            $data["msg"] = $this->quizzService->addQuizz($_POST);
        }
        return $this->render("add-quizz", "Ajouter un quizz", $data);
    }

    public function getOne(int $id): mixed
    {
        if (!isset($_SESSION['connected'])) {
            header('Location: /');
            exit;
        }
        $data = [];
        $data["quizz"] = $this->quizzService->getOne($id);
        return $this->render("show-quizz", "Affichage d'un Quizz", $data);
    }

    public function getAll(): mixed
    {
        $data = [];
        $data["listQuizz"] = $this->quizzService->getAll();
        return $this->render("show-all-quizz", "Affichage des Quizz", $data);
    }
}