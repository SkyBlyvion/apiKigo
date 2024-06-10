<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $label = null;

    // Relation OneToMany avec User
    #[ORM\OneToMany(mappedBy: 'filiere', targetEntity: User::class)]
    private Collection $users;

    // Relation ManyToMany avec Project
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'filieres')]
    private Collection $projects;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;
        return $this;
    }

    // Getters et Setters pour la collection de Users
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): self
    {
        $this->users = $users;
        return $this;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setFiliere($this);
        }
        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            if ($user->getFiliere() === $this) {
                $user->setFiliere(null);
            }
        }
        return $this;
    }

    // Getters et Setters pour la collection de Projects
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function setProjects(Collection $projects): self
    {
        $this->projects = $projects;
        return $this;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->addFiliere($this);
        }
        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeFiliere($this);
        }
        return $this;
    }
}
