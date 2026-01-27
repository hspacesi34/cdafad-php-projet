<?php

namespace App\Repository;

use App\Entity\Entity;
use App\Entity\QuizzCategory;

class QuizzCategoryRepository extends AbstractRepository
{
    public function find(int $id): ?QuizzCategory
    {
        return new QuizzCategory(0,0);
    }

    public function findAll(): array
    {
        return [];
    }

    public function save(Entity $entity): ?QuizzCategory
    {
        try {
            //2 Ecrire la requête SQL
            $sql = "INSERT INTO quizz_category(quizz_id, category_id)
            VALUE(?,?)";
            //3 Préparer la requête
            $req = $this->connect->prepare($sql);
            //4 Assigner les paarmètres(bindParam)
            $req->bindValue(1, $entity->getQuizzId(), \PDO::PARAM_STR);
            $req->bindValue(2, $entity->getCategoryId(), \PDO::PARAM_STR);
            //5 exécuter la requête
            $req->execute();
            //6 récupérer l'id
            $id = $this->connect->lastInsertId();
            $entity->setId($id);
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
        return $entity;
    }
}