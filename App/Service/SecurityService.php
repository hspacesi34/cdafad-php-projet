<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Utils\Tools;
use App\Entity\User;

class SecurityService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register(array $data): string
    {
        //Test si le formulaire est submit

        if (!empty($data["pseudo"]) && !empty($data["email"]) && !empty($data["password"]) && !empty($data["confirm-password"])) {
            //test si les 2 mots de passe sont identiques
            if ($data["password"] == $data["confirm-password"]) {
                //Nettoyage des données
                Tools::sanitize_array($data);
                //Test si le compte n'existe pas déja
                if (!$this->userRepository->isUserExists($data["email"], $data["pseudo"])) {
                    //créer un objet User
                    $user = new User();
                    //Set des attributs
                    $user
                        ->setEmail($data["email"])
                        ->setPseudo($data["pseudo"])
                        ->setFirstname($data["firstname"])
                        ->setLastname($data["lastname"])
                        ->setCreatedAt(new \DateTimeImmutable())
                        ->setRoles("ROLE_USER");
                    //Hash du passwords
                    $hash = password_hash($data["password"], PASSWORD_DEFAULT);
                    $user->setPassword($hash);
                    //ajout en BDD
                    $this->userRepository->save($user);
                    return "Le compte a été ajouté en BDD";
                } else {
                    return "Le compte existe déjà en BDD";
                }
            }
            //Sinon les champs ne sont pas identiques
            else {
                return "Les mots de passe ne sont pas identiques";
            }
        }
        //Sinon les champs ne sont pas remplis 
        else {
            return "Veuillez remplir les champs du formulaire";
        }
    }

    //Méthode pour se connecter
    public function login(array $data): ?string
    {
        //Test si les champs sont remplis
        if (!empty($data["email"]) && !empty($data["password"])) {
            //Nettoyage des données
            Tools::sanitize_array($data);
            //Test si le compte existe
            $user = $this->userRepository->findByEmail($data["email"]);
            if ($user) {
                if (password_verify($data["password"], $user->getPassword())) {
                    $_SESSION["user"]["id"] = $user->getId();
                    $_SESSION["user"]["pseudo"] = $user->getPseudo();
                    $_SESSION["user"]["email"] = $user->getEmail();
                    $_SESSION["user"]["roles"] = $user->getRoles();
                    $_SESSION["connected"] = true;
                    header('Location: /');
                    exit;
                } else {
                    return "Mot de passe invalide";
                }
            } else {
                return "Le compte n'existe pas";
            }
        }
        //Sinon les champs ne sont pas remplis 
        else {
            return "Veuillez remplir les champs du formulaire";
        }
    }
}
