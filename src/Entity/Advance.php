<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Ignore;
use App\Repository\AdvanceRepository;
use Doctrine\ORM\Mapping as ORM;
use FOS\RestBundle\Controller\Annotations\Get;

#[ORM\Entity(repositoryClass: AdvanceRepository::class)]

#[ApiResource()]
class Advance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $participant_amount;

    #[ORM\ManyToOne(targetEntity: Expense::class, inversedBy: 'advances')]
    #[ORM\JoinColumn(nullable: false)]
    private $expense;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'participant_user_advance')]
    #[ORM\JoinColumn(nullable: false)]
    private $participant_user;

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipantAmount(): ?float
    {
        return $this->participant_amount;
    }

    public function setParticipantAmount(float $participant_amount): self
    {
        $this->participant_amount = $participant_amount;

        return $this;
    }

    public function getExpense(): ?expense
    {
        return $this->expense;
    }

    public function setExpense(?expense $expense): self
    {
        $this->expense = $expense;

        return $this;
    }

    public function getParticipantUser(): ?user
    {
        return $this->participant_user;
    }

    public function setParticipantUser(?user $participant_user): self
    {
        $this->participant_user = $participant_user;

        return $this;
    }
}
