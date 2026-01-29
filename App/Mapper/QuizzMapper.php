<?php

namespace App\Mapper;

use App\Entity\Quizz;
use App\DTO\QuizzViewListDTO;

class QuizzMapper
{
    public static function toViewListDTO(Quizz $quizz): QuizzViewListDTO
    {
        return new QuizzViewListDTO(
            id: $quizz->getId(),
            title: $quizz->getTitle(),
            description: $quizz->getDescription(),
            createdAt: $quizz->getCreatedAt()
        );
    }
}