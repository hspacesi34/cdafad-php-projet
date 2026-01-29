<?php

namespace App\Entity;

use App\Entity\Media;
use App\Entity\Entity;
use Mithridatem\Validation\Attributes\Email;
use Mithridatem\Validation\Attributes\Length;
use Mithridatem\Validation\Attributes\NotBlank;
use Mithridatem\Validation\Attributes\Pattern;

class User extends Entity
{
    //Attributs
    private ?int $id;
    private ?string $firstname;
    private ?string $lastname;
    #[NotBlank]
    #[Length(2, 50)]
    private string $pseudo;
    #[NotBlank]
    #[Email]
    private string $email;
    #[NotBlank]
    private string $password;
    private bool $status = true;
    private bool $active = true;
    private bool $deleted = false;
    private string $roles = "ROLE_USER";
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;
    private ?\DateTimeImmutable $deletedAt;
    private ?Media $media = null;

    //Getters et Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    
    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;
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

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable|string $updatedAt): self
    {
        $this->updatedAt = is_string($updatedAt)
            ? new \DateTimeImmutable($updatedAt)
            : $updatedAt;

        return $this;
    }

    public function getDeletedAt(): \DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable|string $deletedAt): self
    {
        $this->deletedAt = is_string($deletedAt)
            ? new \DateTimeImmutable($deletedAt)
            : $deletedAt;

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
            if ($key !== "media") {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            } elseif ($key == "media") {
                $mediaData = json_decode($value, true);
                if (isset($mediaData["url"])) {
                    $this->hydrateMedia($mediaData);
                }
            }
        }
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
