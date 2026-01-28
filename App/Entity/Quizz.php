<?php

namespace App\Entity;

use App\Entity\Entity;
use Mithridatem\Validation\Attributes\Length;
use Mithridatem\Validation\Attributes\NotBlank;

class Quizz extends Entity
{
    private ?int $id;
    #[NotBlank]
    #[Length(2, 50)]
    private string $title;
    #[NotBlank]
    #[Length(3, 255)]
    private string $description;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;
    private User $author;
    private ?int $mediaId;
    private array $categories;

    public function __construct(string $title, string $description, User $author)
    {
        $this->title = $title;
        $this->description = $description;
        $this->categories = [];
        $this->author = $author;
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
    public function setCreatedAt(string|\DateTimeImmutable $createdAt): self
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
    public function setUpdatedAt(string|null|\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = is_string($updatedAt)
            ? new \DateTimeImmutable($updatedAt)
            : $updatedAt;

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
        sort($this->categories);
        return $this;
    }

    /**
     * Get the value of authorId
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * Set the value of authorId
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function hydrateCategories(array $data): self
    {
        if (!isset($data['category_id'], $data['category_name'])) {
            return $this;
        }

        // Éviter les doublons
        foreach ($this->categories as $category) {
            if ($category->getId() === (int) $data['category_id']) {
                return $this;
            }
        }

        $category = (new Category($data['category_name']))
            ->setId((int) $data['category_id'])
            ->setCreatedAt($data['category_createdAt'])
            ->setUpdatedAt($data['category_updatedAt']);

        $this->categories[] = $category;

        return $this;
    }
}
