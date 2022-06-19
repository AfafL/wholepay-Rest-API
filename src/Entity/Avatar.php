<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\AvatarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


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
                'groups' => [ 'read:User:collection','read:Avatar:collection' ],
            ],
        ],
        'post' => [
            'denormalization_context' => [
                'groups' => [ 'write:User:collection' ],
            ],
        ],
    ],
)]



#[ORM\Entity(repositoryClass: AvatarRepository::class)]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        ['read','write:User:collection','read:Avatar:collection']
    )]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(
        ['read', 'read:Avatar:collection']
    )]
    private $image;

    #[ORM\OneToMany(mappedBy: 'avatar', targetEntity: User::class)]

    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAvatar($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
             //set the owning side to null (unless already changed)
            if ($user->getAvatar() === $this) {
                $user->setAvatar(null);
            }
        }

        return $this;
    }
}
