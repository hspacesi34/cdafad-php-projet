<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Entity;
use App\Entity\Quizz;
use App\Entity\QuizzCategory;
use App\Entity\User;

class QuizzRepository extends AbstractRepository
{
    public function find(int $id): ?Quizz
    {
        try {
            //2 Ecrire la requête SQL
            $sql = "SELECT q.id, q.title, q.description, q.created_at AS createdAt, q.updated_at AS updatedAt, q.author_id, q.media_id,
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    'id', c.id,
                    'name', c.name,
                    'createdAt', c.created_at,
                    'updatedAt', c.updated_at
                )
            ) AS categories
            FROM quizz AS q
            INNER JOIN quizz_category AS qc ON q.id = qc.quizz_id
            INNER JOIN category AS c ON qc.category_id = c.id
            WHERE q.id = ?";
            //3 Préparer la requête
            $req = $this->connect->prepare($sql);
            //4 Assigner les paarmètres(bindParam)
            $req->bindParam(1, $id, \PDO::PARAM_INT);
            //5 exécuter la requête
            $req->execute();
            $entity = $req->fetch(\PDO::FETCH_ASSOC);
            if (!$entity) {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        $newQuizz = (new Quizz("", "", new User()))->hydrate($entity);
        foreach (json_decode($entity['categories'], true) as $category) {
            $newCategory = (new Category($category["name"]))->setId($category["id"])->setCreatedAt($category["createdAt"])->setUpdatedAt($category["updatedAt"]);
            $newQuizz->addCategory($newCategory);
        }
        return $newQuizz;
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
            $req->bindValue(4, $entity->getAuthor()->getId(), \PDO::PARAM_INT);
            //5 exécuter la requête
            $req->execute();
            //6 récupérer l'id
            $id = $this->connect->lastInsertId();
            $entity->setId($id);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $entity;
    }
}
