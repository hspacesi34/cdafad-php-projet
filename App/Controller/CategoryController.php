<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Utils\Tools;

class CategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    //Injection du UserRepository
    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function addCategory(): mixed
    {
        $data = [];
        //Test si le formulaire est submit
        if ($this->isFormSubmitted($_POST,  "submit")) {
            //Test si les champs sont remplis
            if (!empty($_POST["name"])) {
                //test si les 2 mots de passe sont identiques
                    //Nettoyage des données
                    Tools::sanitize_array($_POST);
                    //créer un objet User
                    $category = new Category($_POST["name"]);
                    //Set des attributs
                    $category
                        ->setCreatedAt(new \DateTimeImmutable());
                    //Test si le compte n'existe pas déja
                    if (!$this->categoryRepository->isCategoryExists($_POST["name"])) {
                        //ajout en BDD
                        $this->categoryRepository->save($category);
                        $data["msg"] = "La catégorie a été ajoutée en BDD";
                    } else 
                    {
                         $data["msg"] = "La catégorie existe déjà en BDD";
                    }
            } 
            //Sinon les champs ne sont pas remplis 
            else {
                $data["msg"] = "Veuillez remplir les champs du formulaire";
            }
        }
        return $this->render("add-category", "Créer une catégorie", $data);
    }
}