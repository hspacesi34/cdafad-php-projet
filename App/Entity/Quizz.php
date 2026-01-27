<?php

namespace App\Entity;

use App\Entity\Entity;

class Quizz extends Entity
{
    private ?int $id;
    private string $title;
    private string $description;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;
    private int $authorId;
    private ?int $mediaId;
    private array $categories;

    public function __construct(string $title, string $description, int $authorId)
    {
        $this->title = $title;
        $this->description = $description;
        $this->categories = [];
        $this->authorId = $authorId;
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
     * Get the value of title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

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
    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        $this->categories[] = $category;
        return $this;
    }

    public function delCategory(Category $category): self
    {
        foreach ($this->categories as $key => $cat) {
            if ($cat->getId() === $category->getId()) {
                unset($this->categories[$key]);
                break;
            }
        }
        // Réindexer le tableau
        $this->categories = array_values($this->categories);
        return $this;
    }

    /**
     * Get the value of authorId
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * Set the value of authorId
     */
    public function setAuthorId(int $authorId): self
    {
        $this->authorId = $authorId;

        return $this;
    }
}
