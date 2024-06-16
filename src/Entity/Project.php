<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['project:read']],
    denormalizationContext: ['groups' => ['project:write']]
)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['project:read', 'project:write'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['project:read', 'project:write'])]
    private ?bool $isFinish = null;

    #[ORM\Column]
    #[Groups(['project:read', 'project:write'])]
    private ?bool $isActive = null;

    #[ORM\OneToOne(inversedBy: 'project', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['project:read', 'project:write'])]
    private ?Post $post = null;

    #[ORM\OneToMany(mappedBy: 'project',targetEntity: Message::class, cascade: ['persist', 'remove'])]
    #[Groups(['project:read', 'project:write'])]
    private ?Collection $messages;

    #[ORM\ManyToMany(targetEntity:Filiere::class, inversedBy:"projects")]
    #[ORM\JoinTable(name:"project_filiere")]
    #[Groups(['project:read', 'project:write'])]
    private Collection $filieres;

    // mapping table avec project et users
    #[ORM\ManyToMany(targetEntity:User::class, inversedBy:"projects")]
    #[ORM\JoinTable(name:"project_user")]
    #[Groups(['project:read', 'project:write'])]
    private Collection $users;

    // mapping competences et project manytomany
    #[ORM\ManyToMany(targetEntity:Competence::class, inversedBy:"projects")]
    #[ORM\JoinTable(name:"project_competence")]
    #[Groups(['project:read', 'project:write'])]
    private Collection $competences;


    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->filieres = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
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
        return $this->competences;
    }

    // Add and remove users
    public function addUser(User $user): self {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProject($this); // Ensure bidirectional synchronization
        }
        return $this;
    }

    public function removeUser(User $user): self {
        if ($this->users->removeElement($user)) {
            $user->removeProject($this);
        }
        return $this;
    }

    // Add and remove filieres
    public function addFiliere(Filiere $filiere): self {
        if (!$this->filieres->contains($filiere)) {
            $this->filieres->add($filiere);
            $filiere->addProject($this); // Ensure bidirectional synchronization
        }
        return $this;
    }

    public function removeFiliere(Filiere $filiere): self {
        if ($this->filieres->removeElement($filiere)) {
            $filiere->removeProject($this);
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



    public function getFilieres(): Collection
    {
        return $this->filieres;
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

    public function addMessage(Message $message): self {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setProject($this);
        }
        return $this;
    }
    
    public function removeMessage(Message $message): self {
        if ($this->messages->removeElement($message)) {
            $message->setProject(null);
        }
        return $this;
    }

    /**
     * Get the value of messages
     *
     * @return ?Collection
     */
    public function getMessages(): ?Collection
    {
        return $this->messages;
    }

    /**
     * Set the value of messages
     *
     * @param ?Collection $messages
     *
     * @return self
     */
    public function setMessages(?Collection $messages): self
    {
        $this->messages = $messages;

        return $this;
    }
}
