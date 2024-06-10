<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
#[ApiFilter(
    SearchFilter::class, properties: [
        'email' => 'exact',
        'id' => 'exact',
    ]
)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups([ 'user:write'])]
    private ?string $password = null;


    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $lastname = null;


    #[ORM\Column(length: 90, nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $biographie = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $reve = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Post $post = null;

    //relation avec contact
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Contact::class, cascade: ['persist', 'remove'])]
    #[Groups(['user:read', 'user:write'])]
    private Collection $contacts;

    //relation filiere, un user a une seule filiere
    #[ORM\ManyToOne(targetEntity: Filiere::class, inversedBy: 'users', cascade: ['persist', 'remove'])]
    #[Groups(['user:read', 'user:write'])]
    private ?Filiere $filiere = null;

    // relation user a project, manytomany
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'users')]
    #[Groups(['user:read', 'user:write'])]
    private Collection $projects;

    //relation user message
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Message::class)]
    #[Groups(['user:read', 'user:write'])]
    private Collection $messages;

    //relation compétences et user manytomany
    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'users')]
    #[Groups(['user:read', 'user:write'])]
    private Collection $competences;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }



    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): static
    {
        // unset the owning side of the relation if necessary
        if ($post === null && $this->post !== null) {
            $this->post->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($post !== null && $post->getUser() !== $this) {
            $post->setUser($this);
        }

        $this->post = $post;

        return $this;
    }



    /**
     * Get the value of biographie
     *
     * @return ?string
     */
    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    /**
     * Set the value of biographie
     *
     * @param ?string $biographie
     *
     * @return self
     */
    public function setBiographie(?string $biographie): self
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get the value of contacts
     *
     * @return Collection
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    /**
     * Set the value of contacts
     *
     * @param Collection $contacts
     *
     * @return self
     */
    public function setContacts(Collection $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Get the value of reve
     *
     * @return ?string
     */
    public function getReve(): ?string
    {
        return $this->reve;
    }

    /**
     * Set the value of reve
     *
     * @param ?string $reve
     *
     * @return self
     */
    public function setReve(?string $reve): self
    {
        $this->reve = $reve;

        return $this;
    }

    /**
     * Get the value of filiere
     *
     * @return ?Filiere
     */
    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    /**
     * Set the value of filiere
     *
     * @param ?Filiere $filiere
     *
     * @return self
     */
    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    /**
     * Get the value of projects
     *
     * @return Collection
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    /**
     * Set the value of projects
     *
     * @param Collection $projects
     *
     * @return self
     */
    public function setProjects(Collection $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * Get the value of messages
     *
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    /**
     * Set the value of messages
     *
     * @param Collection $messages
     *
     * @return self
     */
    public function setMessages(Collection $messages): self
    {
        $this->messages = $messages;

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

    // Add and remove projects
    public function addProject(Project $project): self {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addUser($this); // Ensure bidirectional synchronization
        }
        return $this;
    }

    public function removeProject(Project $project): self {
        if ($this->projects->removeElement($project)) {
            $project->removeUser($this);
        }
        return $this;
    }

    // Add and remove competences
    public function addCompetence(Competence $competence): self {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
            $competence->addUser($this); // Ensure bidirectional synchronization
        }
        return $this;
    }

    public function removeCompetence(Competence $competence): self {
        if ($this->competences->removeElement($competence)) {
            $competence->removeUser($this);
        }
        return $this;
    }

    // Add and remove messages
    public function addMessage(Message $message): self {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUser($this); // Set the inverse side
        }
        return $this;
    }

    public function removeMessage(Message $message): self {
        if ($this->messages->removeElement($message)) {
            $message->setUser(null);
        }
        return $this;
    }

    // Add and remove contacts
    public function addContact(Contact $contact): self {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setUser($this); // Set the inverse side
        }
        return $this;
    }

    public function removeContact(Contact $contact): self {
        if ($this->contacts->removeElement($contact)) {
            $contact->setUser(null);
        }
        return $this;
    }

}
