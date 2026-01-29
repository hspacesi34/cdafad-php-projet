<?php

namespace App\Service;

use App\DTO\UserLoginDTO;
use App\DTO\UserRegisterDTO;
use App\Entity\Media;
use App\Repository\UserRepository;
use App\Utils\Tools;
use App\Entity\User;
use App\Mapper\UserMapper;

class SecurityService
{
    private UserRepository $userRepository;
    private MediaService $mediaService;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->mediaService = new MediaService();
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
                    $media = !empty($data["mediaId"])
                        ? $data["mediaId"]
                        : null;
                    $userRegisterDto = new UserRegisterDTO(
                        firstname: $data["firstname"],
                        lastname: $data["lastname"],
                        pseudo: $data["pseudo"],
                        email: $data["email"],
                        password: $data["password"],
                        createdAt: new \DateTimeImmutable()
                    );
                    $user = UserMapper::toUserDTO($userRegisterDto);
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

                    $user->setMedia($media);
                    //Valider l'objet
                    $msg = Tools::validator($user);
                    if (isset($msg)) {
                        return $msg;
                    }
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
            $userLoginDTO = new UserLoginDTO($data["email"], $data["password"]);
            //Nettoyage des données
            Tools::sanitize_recursive($userLoginDTO);
            //Valider l'objet
            $msg = Tools::validator($userLoginDTO);
            if (isset($msg)) {
                return $msg;
            }
            //Test si le compte existe
            $user = $this->userRepository->findByEmail($userLoginDTO->email);
            if ($user) {
                if (password_verify($userLoginDTO->password, $user->getPassword())) {
                    $_SESSION['user'] = [
                        'firstname' => $user->getFirstname(),
                        'lastname' => $user->getLastname(),
                        'roles' => $user->getRoles(),
                        'email' => $user->getEmail(),
                        'pseudo' => $user->getPseudo()
                    ];
                    if ($user->getMedia() !== null) {
                        $_SESSION['user']['media'] = [
                            "url" => $user->getMedia()->getUrl(),
                            "alt" => $user->getMedia()->getAlt()
                        ];
                    }
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

    public function getProfil(): User
    {
        $user = (new User())
            ->setFirstname($_SESSION["user"]["firstname"])
            ->setLastname($_SESSION["user"]["lastname"])
            ->setEmail($_SESSION["user"]["email"])
            ->setPseudo($_SESSION["user"]["pseudo"]);
        if (isset($_SESSION["user"]["media"])) {
            $user->setMedia(new Media()->setUrl($_SESSION["user"]["media"]["url"])->setAlt($_SESSION["user"]["media"]["alt"]));
        }
        return $user;
    }
}
