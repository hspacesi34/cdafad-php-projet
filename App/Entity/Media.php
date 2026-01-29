<?php

namespace App\Entity;

use App\Entity\Entity;

class Media extends Entity
{
    //Attributs
    private ?int $id;
    private string $url;
    private string $alt;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;

    //Getters et Setters
    public function getId():?int
    {
        return $this->id;
    }

    public function setId(int $id):self
    {
        $this->id = $id;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable|string $createdAt): self
    {
        $this->createdAt = is_string($createdAt)
            ? new \DateTimeImmutable($createdAt)
            : $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable|string|null $updatedAt): self
    {
        $this->updatedAt = is_string($updatedAt)
            ? new \DateTimeImmutable($updatedAt)
            : $updatedAt;

        return $this;
    }
}