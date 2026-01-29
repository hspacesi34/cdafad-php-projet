<?php

namespace App\Mapper;

use App\Entity\User;
use App\DTO\UserRegisterDTO;

class UserMapper
{
    public static function toUserDTO(UserRegisterDTO $userRegisterDTO): User
    {
        return new User()
            ->setFirstname($userRegisterDTO->getFirstname())
            ->setLastname($userRegisterDTO->getLastname())
            ->setPseudo($userRegisterDTO->getPseudo())
            ->setEmail($userRegisterDTO->getEmail())
            ->setPassword($userRegisterDTO->getPassword())
            ->setCreatedAt($userRegisterDTO->getCreatedAt());
    }
}
