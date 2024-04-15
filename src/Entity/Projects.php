<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?array $filieres = null;

    #[ORM\Column(nullable: true)]
    private ?array $competences = null;

    #[ORM\Column]
    private ?bool $ouvert = null;

    #[ORM\Column]
    private ?bool $termine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilieres(): ?array
    {
        return $this->filieres;
    }

    public function setFilieres(?array $filieres): static
    {
        $this->filieres = $filieres;

        return $this;
    }

    public function getCompetences(): ?array
    {
        return $this->competences;
    }

    public function setCompetences(?array $competences): static
    {
        $this->competences = $competences;

        return $this;
    }

    public function isOuvert(): ?bool
    {
        return $this->ouvert;
    }

    public function setOuvert(bool $ouvert): static
    {
        $this->ouvert = $ouvert;

        return $this;
    }

    public function isTermine(): ?bool
    {
        return $this->termine;
    }

    public function setTermine(bool $termine): static
    {
        $this->termine = $termine;

        return $this;
    }
}
