<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date_created = null;

    #[ORM\ManyToOne(inversedBy: 'message', cascade: ['persist', 'remove'])]
    private ?Project $project = null;

    //relation avec user, un user peut avoir plusieurs messages, un message appartient a un seul user
    #[ORM\ManyToOne(inversedBy: 'messages', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private ?User $user = null;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateCreated(): ?\DateTimeImmutable
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeImmutable $date_created): static
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getproject(): ?project
    {
        return $this->project;
    }

    public function setproject(?project $project): static
    {
        $this->project = $project;

        return $this;
    }

   

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
