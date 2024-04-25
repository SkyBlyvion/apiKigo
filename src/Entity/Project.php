<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ApiResource]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isFinish = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Competence::class)]
    private Collection $competence;

    #[ORM\OneToOne(inversedBy: 'project', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    #[ORM\OneToMany(mappedBy: 'project', cascade: ['persist', 'remove'])]
    private ?Message $message = null;

    #[ORM\ManyToMany(targetEntity:Filiere::class, inversedBy:"projects")]
    #[ORM\JoinTable(name:"project_filiere")]
    private Collection $filieres;

    // mapping table avec project et users
    #[ORM\ManyToMany(targetEntity:User::class, inversedBy:"projects")]
    #[ORM\JoinTable(name:"project_user")]
    private Collection $users;

    // mapping competences et project manytomany
    #[ORM\ManyToMany(targetEntity:Competence::class, inversedBy:"projects")]
    #[ORM\JoinTable(name:"project_competence")]
    private Collection $competences;


    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->filieres = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsFinish(): ?bool
    {
        return $this->isFinish;
    }

    public function setIsFinish(bool $isFinish): self
    {
        $this->isFinish = $isFinish;
        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence->add($competence);
            $competence->setProject($this);
        }
        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competence->removeElement($competence)) {
            if ($competence->getProject() === $this) {
                $competence->setProject(null);
            }
        }
        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;
        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        if ($message === null && $this->message !== null) {
            $this->message->setProject(null);
        }
        if ($message !== null && $message->getProject() !== $this) {
            $message->setProject($this);
        }
        $this->message = $message;
        return $this;
    }

    public function getFilieres(): Collection
    {
        return $this->filieres;
    }

    public function addFiliere(Filiere $filiere): self
    {
        if (!$this->filieres->contains($filiere)) {
            $this->filieres[] = $filiere;
            $filiere->getProjects()->add($this);
        }
        return $this;
    }

    public function removeFiliere(Filiere $filiere): self
    {
        if ($this->filieres->removeElement($filiere)) {
            $filiere->getProjects()->removeElement($this);
        }
        return $this;
    }

    /**
     * Get the value of users
     *
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * Set the value of users
     *
     * @param Collection $users
     *
     * @return self
     */
    public function setUsers(Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get the value of competences
     *
     * @return Collection
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    /**
     * Set the value of competences
     *
     * @param Collection $competences
     *
     * @return self
     */
    public function setCompetences(Collection $competences): self
    {
        $this->competences = $competences;

        return $this;
    }
}
