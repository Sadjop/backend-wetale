<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
#[ORM\Table(name: 'favorite', uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'user_story_unique', columns: ['user_id', 'story_id'])
])]
#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_USER') and object.getUser() == user"),
        new Post(security: "is_granted('ROLE_USER')"),
        new Put(security: "is_granted('ROLE_USER') and object.getUser() == user"),
        new Delete(security: "is_granted('ROLE_USER') and object.getUser() == user")
    ]
)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Story::class, inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Story $story = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): static
    {
        $this->story = $story;
        return $this;
    }
}
