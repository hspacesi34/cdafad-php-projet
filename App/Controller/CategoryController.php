<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Service\CategoryService;

class CategoryController extends AbstractController
{
    private CategoryService $categoryService;

    //Injection du UserRepository
    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    public function addCategory(): mixed
    {
        $data = [];
        //Test si le formulaire est submit
        if ($this->isFormSubmitted($_POST,  "submit")) {
            $data["msg"] = $this->categoryService->addCategory($_POST);
        }
        return $this->render("add-category", "Créer une catégorie", $data);
    }

    public function showAllCategories(): mixed
    {
        $data = [];
        $data["categories"] = $this->categoryService->getAllCategories();
        $component = $this->renderComponent("show-all-categories", $data);
        return $component;
    }
}