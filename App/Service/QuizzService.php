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
    private MediaService $mediaService;


    public function __construct()
    {
        $this->quizzRepository = new QuizzRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->quizzCategoryRepository = new QuizzCategoryRepository();
        $this->mediaService = new MediaService();
    }

    public function addQuizz(array $data): string
    {
        if (!empty($data["title"] || !empty($data["description"]))) {
            Tools::sanitize_array($data);
            $author = (new User())->setId($_SESSION["user"]["id"]);
            $quizz = (new Quizz())
                ->setTitle($data["title"])
                ->setDescription($data["description"])
                ->setAuthor($author)
                ->setCreatedAt(new \DateTimeImmutable());
            //Valider l'objet
            $msg = Tools::validator($quizz);
            if (isset($msg)) {
                return $msg;
            }
            //test si le media existe
            if (isset($_FILES["img"]) && !empty($_FILES["img"]["tmp_name"])) {
                try {
                    //Import du fichier
                    $media = $this->mediaService->addMedia($_FILES["img"]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }
            //Image par default
            else {
                $media = $this->mediaService->getDefaultImg();
            }

            $quizz->setMedia($media);
            $savedQuizz = $this->quizzRepository->save($quizz);

            foreach ($data["categories"] as $category) {
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

    public function getAll(): array
    {
        return $this->quizzRepository->findAll();
    }
}
