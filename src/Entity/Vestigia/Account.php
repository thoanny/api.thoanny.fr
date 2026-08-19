<?php

namespace App\Entity\Vestigia;

use App\Entity\User;
use App\Repository\Vestigia\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ORM\Table(name: '`vestigia_account`')]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['me'])]
    private ?string $nickname = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'account', cascade: ['persist'], orphanRemoval: true)]
    private Collection $characters;

    /**
     * @var Collection<int, InventoryItem>
     */
    #[ORM\OneToMany(targetEntity: InventoryItem::class, mappedBy: 'account', orphanRemoval: true)]
    private Collection $inventoryItems;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->inventoryItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setAccount($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getAccount() === $this) {
                $character->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InventoryItem>
     */
    public function getInventoryItems(): Collection
    {
        return $this->inventoryItems;
    }

    public function addInventoryItem(InventoryItem $inventoryItem): static
    {
        if (!$this->inventoryItems->contains($inventoryItem)) {
            $this->inventoryItems->add($inventoryItem);
            $inventoryItem->setAccount($this);
        }

        return $this;
    }

    public function removeInventoryItem(InventoryItem $inventoryItem): static
    {
        if ($this->inventoryItems->removeElement($inventoryItem)) {
            // set the owning side to null (unless already changed)
            if ($inventoryItem->getAccount() === $this) {
                $inventoryItem->setAccount(null);
            }
        }

        return $this;
    }

    #[Groups(['me'])]
    public function getFullnickname(): string
    {
        $discriminator = str_pad($this->characters->count(), 4, '0', STR_PAD_LEFT);
        return "$this->nickname#$discriminator";
    }
}
