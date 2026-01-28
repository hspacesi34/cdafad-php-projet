<?php

namespace App\Service;

use App\Entity\Quizz;
use App\Entity\QuizzCategory;
use App\Entity\User;
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
            $author = (new User())->setId($_SESSION["user"]["id"]);
            $quizz = (new Quizz($data["title"], $data["description"], $author))->setCreatedAt(new \DateTimeImmutable());
            //Valider l'objet
            $msg = Tools::validator($quizz);
            if (isset($msg)) {
                return $msg;
            }
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

    public function getOne(int $id): Quizz
    {
        return $this->quizzRepository->find($id);
    }
}
