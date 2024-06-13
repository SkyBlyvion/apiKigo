<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeImmutable;
use DateTimeInterface;


#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['post:read']],
    denormalizationContext: ['groups' => ['post:write']],
)]
class Post
{
    // Define post types
    const TYPE_PROJECT = 1;
    const TYPE_PARTICIPATION = 2;
    const TYPE_INSPIRATION = 3;
    const TYPE_REALIZATION = 4;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['post:read', 'post:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['post:read', 'post:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['post:read', 'post:write'])]
    private ?string $text = null;

    #[ORM\Column]
    #[Groups(['post:read', 'post:write'])]
    private ?int $type = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['post:read', 'post:write'])]
    private ?\DateTimeImmutable $created_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['post:read', 'post:write'])]
    private ?\DateTimeInterface $updated_date = null;

    #[ORM\OneToOne(mappedBy: 'post', cascade: ['persist', 'remove'])]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'post', cascade: ['persist', 'remove'])]
    #[Groups(['post:read'])]
    private ?Media $media = null;

    // Getters and Setters...

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeImmutable $created_date): static
    {
        $this->created_date = $created_date;
        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updated_date;
    }

    public function setUpdatedDate(\DateTimeInterface $updated_date): static
    {
        $this->updated_date = $updated_date;
        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): static
    {
        // set the owning side of the relation if necessary
        if ($project->getPost() !== $this) {
            $project->setPost($this);
        }
        $this->project = $project;
        return $this;
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

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        // unset the owning side of the relation if necessary
        if ($media === null && $this->media !== null) {
            $this->media->setPost(null);
        }

        // set the owning side of the relation if necessary
        if ($media !== null && $media->getPost() !== $this) {
            $media->setPost($this);
        }
        $this->media = $media;
        return $this;
    }
}
