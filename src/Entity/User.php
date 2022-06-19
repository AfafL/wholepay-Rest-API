<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Ignore;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read:Users:items']
            ]
        ]
            ],
    collectionOperations: [
            'get' => [
                'normalization_context' => [
                    'groups' => [ 'read:User:collection' ],
                ],
            ],
            'post' => [
                'denormalization_context' => [
                    'groups' => [ 'write:User:collection' ],
                ],
            ],
        ],
    )]

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(
        ['read','read:User:collection','write:User:collection','read:Users:items']
    )]
    private $name;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(
        ['read','read:User:collection','write:User:collection','read:Users:items']
    )]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(
        ['read','write:User:collection','read:Users:items']
    )]
    private $password;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(
        ['read','write:User:collection','read:Users:items']
    )]
    private $email;

    #[ORM\ManyToOne(targetEntity: Avatar::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        ['write:User:collection']
    )]
    private $avatar;

    #[ORM\OneToMany(mappedBy: 'creator_user', targetEntity: 
    WholepayEvent::class)]
    #[Groups(
        ['read']//Ajouter 14 juin par afaf
    )]
    private $wholepayEvents;

    #[ORM\OneToMany(mappedBy: 'paid_by_user', targetEntity: Expense::class)]
    //#[Ignore]
     
    private $expenses;

    #[ORM\OneToMany(mappedBy: 'participant_user', targetEntity: Advance::class)]
   //#[Ignore]
    private $participant_user_advance;

    public function __construct()
    {
        $this->wholepayEvents = new ArrayCollection();
        $this->expenses = new ArrayCollection();
        $this->participant_user_advance = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?avatar $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, WholepayEvent>
     */
    public function getWholepayEvents(): Collection
    {
        return $this->wholepayEvents;
    }

    public function addWholepayEvent(WholepayEvent $wholepayEvent): self
    {
        if (!$this->wholepayEvents->contains($wholepayEvent)) {
            $this->wholepayEvents[] = $wholepayEvent;
            $wholepayEvent->setCreatorUser($this);
        }

        return $this;
    }

    public function removeWholepayEvent(WholepayEvent $wholepayEvent): self
    {
        if ($this->wholepayEvents->removeElement($wholepayEvent)) {
            // set the owning side to null (unless already changed)
            if ($wholepayEvent->getCreatorUser() === $this) {
                $wholepayEvent->setCreatorUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expense>
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expense $expense): self
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses[] = $expense;
            $expense->setPaidByUser($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getPaidByUser() === $this) {
                $expense->setPaidByUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Advance>
     */
    //#[Ignore]
    public function getParticipantUserAdvance(): Collection
    {
        return $this->participant_user_advance;
    }

    public function addParticipantUserAdvance(Advance $participantUserAdvance): self
    {
        if (!$this->participant_user_advance->contains($participantUserAdvance)) {
            $this->participant_user_advance[] = $participantUserAdvance;
            $participantUserAdvance->setParticipantUser($this);
        }

        return $this;
    }

    public function removeParticipantUserAdvance(Advance $participantUserAdvance): self
    {
        if ($this->participant_user_advance->removeElement($participantUserAdvance)) {
            // set the owning side to null (unless already changed)
            if ($participantUserAdvance->getParticipantUser() === $this) {
                $participantUserAdvance->setParticipantUser(null);
            }
        }

        return $this;
    }
}
