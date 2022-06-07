<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Ignore;
use App\Repository\ExpenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
//#[ApiResource()]
#[ORM\Entity(repositoryClass: ExpenseRepository::class)]
class Expense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'float')]
    private $amount;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    private $paid_by_user;

    #[ORM\ManyToOne(targetEntity: wholepayEvent::class, inversedBy: 'wholepayExpense')]
    #[ORM\JoinColumn(nullable: false)]
    private $wholepay;

    #[ORM\OneToMany(mappedBy: 'expense', targetEntity: Advance::class)]
    private $advances;

    public function __construct()
    {
        $this->advances = new ArrayCollection();
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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPaidByUser(): ?user
    {
        return $this->paid_by_user;
    }

    public function setPaidByUser(?user $paid_by_user): self
    {
        $this->paid_by_user = $paid_by_user;

        return $this;
    }

    public function getWholepay(): ?wholepayEvent
    {
        return $this->wholepay;
    }

    public function setWholepay(?wholepayEvent $wholepay): self
    {
        $this->wholepay = $wholepay;

        return $this;
    }

    /**
     * @return Collection<int, Advance>
     */
    public function getAdvances(): Collection
    {
        return $this->advances;
    }

    public function addAdvance(Advance $advance): self
    {
        if (!$this->advances->contains($advance)) {
            $this->advances[] = $advance;
            $advance->setExpense($this);
        }

        return $this;
    }

    public function removeAdvance(Advance $advance): self
    {
        if ($this->advances->removeElement($advance)) {
            // set the owning side to null (unless already changed)
            if ($advance->getExpense() === $this) {
                $advance->setExpense(null);
            }
        }

        return $this;
    }
}
