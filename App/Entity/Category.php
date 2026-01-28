<?php

namespace App\Entity;

use App\Entity\Entity;

class Category extends Entity
{
    private ?int $id;
    private string $name;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     */
    public function setCreatedAt(\DateTimeImmutable|string $createdAt): self
    {
        $this->createdAt = is_string($createdAt)
            ? new \DateTimeImmutable($createdAt)
            : $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     */
    public function setUpdatedAt(\DateTimeImmutable|string|null $updatedAt): self
    {
        $this->updatedAt = is_string($updatedAt)
            ? new \DateTimeImmutable($updatedAt)
            : $updatedAt;

        return $this;
    }
}
