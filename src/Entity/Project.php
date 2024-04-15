<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\projectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: projectRepository::class)]
#[ApiResource]
class project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $filiere = null;

    #[ORM\Column]
    private ?bool $isFinish = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Competence::class)]
    private Collection $competence;

    #[ORM\OneToOne(inversedBy: 'project', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    #[ORM\OneToOne(mappedBy: 'project', cascade: ['persist', 'remove'])]
    private ?Message $message = null;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isIsFinish(): ?bool
    {
        return $this->isFinish;
    }

    public function setIsFinish(bool $isFinish): static
    {
        $this->isFinish = $isFinish;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

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
            $competence->setproject($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): static
    {
        if ($this->competence->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getproject() === $this) {
                $competence->setproject(null);
            }
        }

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(Post $post): static
    {
        $this->post = $post;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): static
    {
        // unset the owning side of the relation if necessary
        if ($message === null && $this->message !== null) {
            $this->message->setProject(null);
        }

        // set the owning side of the relation if necessary
        if ($message !== null && $message->getProject() !== $this) {
            $message->setProject($this);
        }

        $this->message = $message;

        return $this;
    }
}
