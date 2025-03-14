<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\StoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_USER')"),
        new GetCollection(security: "is_granted('ROLE_USER')"),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ],
    normalizationContext: ['groups' => ['story:read']],
    denormalizationContext: ['groups' => ['story:write']]
)]
class Story
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['story:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['story:read', 'story:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['story:read', 'story:write'])]
    private ?string $blurb = null;

    #[ORM\Column(length: 50)]
    #[Groups(['story:read', 'story:write'])]
    private ?string $status = null;

    #[ORM\Column(length: 50)]
    #[Groups(['story:read', 'story:write'])]
    private ?string $type = null;

    #[ORM\Column]
    #[Groups(['story:read', 'story:write'])]
    private ?int $lastGeneratedChapter = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['story:read', 'story:write'])]
    private ?float $completionRatio = null;

    #[ORM\Column]
    #[Groups(['story:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Chapter>
     */
    #[ORM\OneToMany(targetEntity: Chapter::class, mappedBy: 'story', cascade: ['persist', 'remove'])]
    private Collection $chapters;

    /**
     * @var Collection<int, Library>
     */
    #[ORM\ManyToMany(targetEntity: Library::class, mappedBy: 'stories')]
    private Collection $libraries;

    /**
     * @var Collection<int, Favorite>
     */
    #[ORM\OneToMany(targetEntity: Favorite::class, mappedBy: 'story', cascade: ['persist', 'remove'])]
    private Collection $favorites;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
        $this->libraries = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $now = new \DateTimeImmutable();
        if ($this->createdAt === null) {
            $this->createdAt = $now;
        }
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getBlurb(): ?string
    {
        return $this->blurb;
    }

    public function setBlurb(string $blurb): static
    {
        $this->blurb = $blurb;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getLastGeneratedChapter(): ?int
    {
        return $this->lastGeneratedChapter;
    }

    public function setLastGeneratedChapter(int $lastGeneratedChapter): static
    {
        $this->lastGeneratedChapter = $lastGeneratedChapter;
        return $this;
    }

    public function getCompletionRatio(): ?float
    {
        return $this->completionRatio;
    }

    public function setCompletionRatio(?float $completionRatio): static
    {
        $this->completionRatio = $completionRatio;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Chapter>
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    /**
     * @return Collection<int, Library>
     */
    public function getLibraries(): Collection
    {
        return $this->libraries;
    }

    public function addLibrary(Library $library): static
    {
        if (!$this->libraries->contains($library)) {
            $this->libraries->add($library);
            $library->addStory($this);
        }
        return $this;
    }

    public function removeLibrary(Library $library): static
    {
        if ($this->libraries->removeElement($library)) {
            $library->removeStory($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }
}
