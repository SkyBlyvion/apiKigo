<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
#[ApiResource]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $biography = null;

    #[ORM\Column]
    private ?int $filiere = null;

    #[ORM\OneToOne(inversedBy: 'profil', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'profil', cascade: ['persist', 'remove'])]
    private ?Contact $contact = null;

    #[ORM\OneToMany(mappedBy: 'profil', targetEntity: Competence::class)]
    private Collection $competence;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getFiliere(): ?int
    {
        return $this->filiere;
    }

    public function setFiliere(int $filiere): static
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

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
            $this->contact->setProfil(null);
        }

        // set the owning side of the relation if necessary
        if ($contact !== null && $contact->getProfil() !== $this) {
            $contact->setProfil($this);
        }

        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): static
    {
        if (!$this->competence->contains($competence)) {
            $this->competence->add($competence);
            $competence->setProfil($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): static
    {
        if ($this->competence->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getProfil() === $this) {
                $competence->setProfil(null);
            }
        }

        return $this;
    }
}
