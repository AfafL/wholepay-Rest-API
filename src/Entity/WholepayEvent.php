<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WholepayEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Ignore;

use Doctrine\ORM\Mapping as ORM;
#[ApiResource()]
#[ORM\Entity(repositoryClass: WholepayEventRepository::class)]
class WholepayEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $title;

    #[ORM\Column(type: 'string', length: 100)]
    private $description;

    #[ORM\Column(type: 'string', length: 50)]
    private $currency;

    #[ORM\Column(type: 'string', length: 100)]
    private $category;

    #[ORM\ManyToMany(targetEntity: User::class)]
    #[Ignore]
    private $participant_user;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'wholepayEvents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private $creator_user;

    #[ORM\OneToMany(mappedBy: 'wholepay', targetEntity: Expense::class)]
    #[Ignore]
    private $wholepayExpense;

    #[ORM\OneToMany(mappedBy: 'wholepay', targetEntity: Invitation::class)]
    #[Ignore]
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

    /**
     * @return Collection<int, user>
     */
    public function getParticipantUser(): Collection
    {
        return $this->participant_user;
    }

    public function addParticipantUser(User $participantUser): self
    {
        if (!$this->participant_user->contains($participantUser)) {
            $this->participant_user[] = $participantUser;
        }

        return $this;
    }

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
