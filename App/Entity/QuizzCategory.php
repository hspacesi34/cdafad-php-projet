<?php

namespace App\Entity;

class QuizzCategory extends Entity
{
    private ?int $id;
    private int $quizzId;
    private int $categoryId;

    public function __construct(int $quizzId, int $categoryId)
    {
        $this->quizzId = $quizzId;
        $this->categoryId = $categoryId;
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
     * Get the value of quizzId
     */
    public function getQuizzId(): int
    {
        return $this->quizzId;
    }

    /**
     * Set the value of quizzId
     */
    public function setQuizzId(int $quizzId): self
    {
        $this->quizzId = $quizzId;

        return $this;
    }

    /**
     * Get the value of categoryId
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * Set the value of categoryId
     */
    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}
