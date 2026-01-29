<?php

namespace App\Repository;

use App\DTO\DTO;
use App\Entity\Category;
use App\Entity\Entity;

class CategoryRepository extends AbstractRepository
{
    public function find(int $id): ?Category
    {
        return new Category("");
    }

    public function findAll(): array
    {
        try {
            //2 Ecrire la requête SQL
            $sql = "SELECT c.id, c.name FROM category AS c ORDER BY c.name";
            //3 Préparer la requête
            $req = $this->connect->prepare($sql);
            //5 exécuter la requête
            $req->execute();
            //6 récupérer la réponse (SELECT)
            $categories = $req->fetchAll(\PDO::FETCH_ASSOC);
            $categoriesObj = [];
            if (count($categories) > 0) {
                foreach ($categories as $category) {
                    $categoriesObj[] = (new Category(""))->hydrate($category);
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
        return $categoriesObj;
    }

    public function save(Entity $entity): ?Category
    {
        try {
            //2 Ecrire la requête SQL
            $sql = "INSERT INTO category(`name`, created_at)
            VALUE(?,?)";
            //3 Préparer la requête
            $req = $this->connect->prepare($sql);
            //4 Assigner les paarmètres(bindParam)
            $req->bindValue(1, $entity->getName(), \PDO::PARAM_STR);
            $req->bindValue(2, $entity->getCreatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
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

    public function isCategoryExists(string $name): bool
    {
        try {
            //2 Ecrire la requête SQL
            $sql = "SELECT c.id FROM category AS c WHERE c.name = ?";
            //3 Préparer la requête
            $req = $this->connect->prepare($sql);
            //4 Assigner les paarmètres(bindParam)
            $req->bindParam(1, $name, \PDO::PARAM_STR);
            //5 exécuter la requête
            $req->execute();
            //6 récupérer la réponse (SELECT)
            $category = $req->fetch();
            if (empty($category)) {
                return false;
            } else {
                return true;
            }
        } catch (\PDOException $e) {
            return false;
        }
    }
}
