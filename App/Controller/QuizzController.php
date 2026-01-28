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
        $data = [];
        $data["quizz"] = $this->quizzService->getOne($id);
        return dump($data);
    }
}