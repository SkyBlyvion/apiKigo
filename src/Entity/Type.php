<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ApiResource]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    #[ORM\OneToOne(mappedBy: 'type', cascade: ['persist', 'remove'])]
    private ?Contact $contact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        // unset the owning side of the relation if necessary
        if ($contact === null && $this->contact !== null) {
            $this->contact->setType(null);
        }

        // set the owning side of the relation if necessary
        if ($contact !== null && $contact->getType() !== $this) {
            $contact->setType($this);
        }

        $this->contact = $contact;

        return $this;
    }
}
