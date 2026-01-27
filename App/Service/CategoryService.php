<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Utils\Tools;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function addCategory(array $data): string
    {
        //Test si les champs sont remplis
        if (!empty($data["name"])) {
            //Nettoyage des données
            Tools::sanitize_array($data);
            //Test si la category n'existe pas déja
            if (!$this->categoryRepository->isCategoryExists($data["name"])) {
                //créer un objet Category
                $category = new Category($data["name"]);
                //Set des attributs
                $category
                    ->setCreatedAt(new \DateTimeImmutable());
                //ajout en BDD
                $this->categoryRepository->save($category);
                return "La catégorie a été ajoutée en BDD";
            } else {
                return "La catégorie existe déjà en BDD";
            }
        }
        //Sinon les champs ne sont pas remplis 
        else {
            return "Veuillez remplir les champs du formulaire";
        }
    }

    public function getAllCategories(): array|string
    {
        $categories = $this->categoryRepository->findAll();
        if (count($categories) > 0) {
            return $categories;
        }
        return "La liste est vide";
    }
}
