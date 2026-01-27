<?php

namespace App\Repository;

use App\Entity\Entity;
use App\Entity\Quizz;
use App\Entity\QuizzCategory;

class QuizzRepository extends AbstractRepository
{
    public function find(int $id): ?Quizz
    {
        return new Quizz("","");
    }

    public function findAll(): array
    {
        return [];
    }

    public function save(Entity $entity): ?Quizz
    {
        try {
            //2 Ecrire la requête SQL
            $sql = "INSERT INTO quizz(title, `description`, created_at, author_id)
            VALUE(?,?,?,?)";
            //3 Préparer la requête
            $req = $this->connect->prepare($sql);
            //4 Assigner les paarmètres(bindParam)
            $req->bindValue(1, $entity->getTitle(), \PDO::PARAM_STR);
            $req->bindValue(2, $entity->getDescription(), \PDO::PARAM_STR);
            $req->bindValue(3, $entity->getCreatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $req->bindValue(4, $entity->getAuthorId(), \PDO::PARAM_INT);
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

    public function saveQuizzCategory(): ?QuizzCategory
    {
        try {
            //code...
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}