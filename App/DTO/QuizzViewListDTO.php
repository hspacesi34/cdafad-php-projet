<?php

namespace App\DTO;

class QuizzViewListDTO extends DTO
{
    public int $id;
    public string $title;
    public string $description;
    public \DateTimeImmutable|string $createdAt;
    
    public function setCorrectDateType()
    {
        $this->createdAt = new \DateTimeImmutable($this->createdAt);
    }
}
