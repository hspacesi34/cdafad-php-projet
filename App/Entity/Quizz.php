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
    private ?Media $media;
    private array $categories;

    public function __construct()
    {
        $this->categories = [];
        $this->media = null;
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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function hydrate(array $data): self
    {
        foreach ($data as $key => $value) {
            if ($key !== "categories" && $key !== "author" && $key !== "media") {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            } elseif ($key == "categories") {
                $categoriesData = json_decode($value, true);
                $this->hydrateCategories($categoriesData);
            } elseif ($key == "author") {
                $authorData = json_decode($value, true);
                $this->hydrateAuthor($authorData);
            } elseif ($key == "media") {
                $mediaData = json_decode($value, true);
                if (isset($mediaData["url"])) {
                    $this->hydrateMedia($mediaData);
                }
            }
        }
        return $this;
    }

    private function hydrateCategories(array $categoriesData): self
    {
        foreach ($categoriesData as $category) {
            $this->addCategory(
                (new Category($category['name']))
                    ->setId($category['id'])
                    ->setCreatedAt($category['createdAt'])
                    ->setUpdatedAt($category['updatedAt'])
            );
        }
        return $this;
    }

    private function hydrateAuthor(array $authorData): self
    {
        $this->author = (new User())
            ->setId($authorData['id'])
            ->setPseudo($authorData['pseudo']);
        return $this;
    }

    private function hydrateMedia(array $mediaData): self
    {
        $this->media = new Media()
            ->setUrl($mediaData['url'])
            ->setAlt($mediaData['alt'])
            ->setCreatedAt($mediaData['createdAt']);
        return $this;
    }
}
