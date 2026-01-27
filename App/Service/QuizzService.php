<?php

namespace App\Service;

use App\Entity\Quizz;
use App\Entity\QuizzCategory;
use App\Repository\CategoryRepository;
use App\Repository\QuizzCategoryRepository;
use App\Repository\QuizzRepository;
use App\Utils\Tools;

class QuizzService
{
    private QuizzRepository $quizzRepository;
    private CategoryRepository $categoryRepository;
    private QuizzCategoryRepository $quizzCategoryRepository;

    public function __construct()
    {
        $this->quizzRepository = new QuizzRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->quizzCategoryRepository = new QuizzCategoryRepository();
    }

    public function addQuizz(array $data): string
    {
        if (!empty($data["title"] || !empty($data["description"]))) {
            Tools::sanitize_array($data);
            
            $quizz = new Quizz($data["title"], $data["description"], $_SESSION["user"]["id"])->setCreatedAt(new \DateTimeImmutable());
            $savedQuizz = $this->quizzRepository->save($quizz);

            foreach($data["categories"] AS $category)
            {   
                $newQuizzCategory = new QuizzCategory($savedQuizz->getId(), $category);
                $this->quizzCategoryRepository->save($newQuizzCategory);
            }
            return "Quizz ajouté dans la BDD";
        }
        return "Veuillez remplir tous les champs";
    }
}
