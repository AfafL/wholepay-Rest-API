<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WholepayEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;

#[ApiResource(
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['read']
            ]
        ]
    ],
    collectionOperations: [
            'get' => [
                'normalization_context' => [
                    'groups' => [ 'read:WholepayEvent:collection' ],
                ],
            ],
        ],
    )]


#[ORM\Entity(repositoryClass: WholepayEventRepository::class)]
class WholepayEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
  
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(
        ['read','read:WholepayEvent:collection']
    )]
    private $title;

    #[ORM\Column(type: 'string', length: 100)]
    private $description;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(
        ['read']
    )]
    private $currency;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(
        ['read']
    )]
    private $category;

    #[ORM\ManyToMany(targetEntity: User::class)]
  
    private $participant_user;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'wholepayEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private $creator_user;

    #[ORM\OneToMany(mappedBy: 'wholepay', targetEntity: Expense::class)]

    private $wholepayExpense;

    #[ORM\OneToMany(mappedBy: 'wholepay', targetEntity: Invitation::class)]

    private $invitations;

    public function __construct()
    {
        $this->participant_user = new ArrayCollection();
        $this->wholepayExpense = new ArrayCollection();
        $this->invitations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }


 #[Groups(
        ['read']
    )]
public function getParticipantNamesIDs():array{
$list=[];
foreach($this->participant_user as $value){
    
$list[]=['id'=> $value->getId(),'name'=>$value->getFirstName().' '.$value->getName()];
}
    return $list;
}

    /**
     * @return Collection<int, user>
     */

    public function getParticipantUser(): Collection
    {
        return $this->participant_user;
    }

    /*public function addParticipantUser(User $participantUser): self
    {
        if (!$this->participant_user->contains($participantUser)) {
            $this->participant_user[] = $participantUser;
        }

        return $this;
    }*/

    public function removeParticipantUser(User $participantUser): self
    {
        $this->participant_user->removeElement($participantUser);

        return $this;
    }

    public function getCreatorUser(): ?user
    {
        return $this->creator_user;
    }

    public function setCreatorUser(?user $creator_user): self
    {
        $this->creator_user = $creator_user;

        return $this;
    }

    /**
     * @return Collection<int, Expense>
     */
    public function getWholepayExpense(): Collection
    {
        return $this->wholepayExpense;
    }

    public function addWholepayExpense(Expense $wholepayExpense): self
    {
        if (!$this->wholepayExpense->contains($wholepayExpense)) {
            $this->wholepayExpense[] = $wholepayExpense;
            $wholepayExpense->setWholepay($this);
        }

        return $this;
    }

    public function removeWholepayExpense(Expense $wholepayExpense): self
    {
        if ($this->wholepayExpense->removeElement($wholepayExpense)) {
            // set the owning side to null (unless already changed)
            if ($wholepayExpense->getWholepay() === $this) {
                $wholepayExpense->setWholepay(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setWholepay($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getWholepay() === $this) {
                $invitation->setWholepay(null);
            }
        }

        return $this;
    }
}
