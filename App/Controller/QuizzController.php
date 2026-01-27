<?php

namespace App\Controller;

use App\Service\CategoryService;
use App\Service\QuizzService;

class QuizzController extends AbstractController
{
    private QuizzService $quizzService;
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->quizzService = new QuizzService();
        $this->categoryService = new CategoryService();
    }

    public function addQuizz(): mixed
    {
        $data = [];
        $data["categories"] = $this->categoryService->getAllCategories();
        //Test si le formulaire est submit
        if ($this->isFormSubmitted($_POST,  "submit")) {
            $data["msg"] = $this->quizzService->addQuizz($_POST);
        }
        return $this->render("add-quizz", "Ajouter un quizz", $data);
    }
}