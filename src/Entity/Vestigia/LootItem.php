<?php

namespace App\Entity\Vestigia;

use App\Repository\Vestigia\LootItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LootItemRepository::class)]
#[ORM\Table(name: 'vestigia_loot_item')]
class LootItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $min = null;

    #[ORM\Column]
    private ?int $max = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $rewardItem = null;

    #[ORM\Column]
    private ?int $chance = null;

    #[ORM\ManyToOne(inversedBy: 'loots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(int $min): static
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(int $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function getRewardItem(): ?Item
    {
        return $this->rewardItem;
    }

    public function setRewardItem(?Item $rewardItem): static
    {
        $this->rewardItem = $rewardItem;

        return $this;
    }

    public function getChance(): ?int
    {
        return $this->chance;
    }

    public function setChance(int $chance): static
    {
        $this->chance = $chance;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): static
    {
        $this->item = $item;

        return $this;
    }
}
