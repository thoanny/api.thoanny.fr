<?php

namespace App\Entity\Vestigia;

use App\Repository\Vestigia\GoalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GoalRepository::class)]
#[ORM\Table(name: '`vestigia_goal`')]
class Goal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['goals'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['goals'])]
    private ?string $label = null;

    #[ORM\Column(length: 10)]
    #[Groups(['goals'])]
    private ?string $type = null;

    #[ORM\Column]
    #[Groups(['goals'])]
    private ?int $duration = null;

    #[ORM\Column]
    #[Groups(['goals'])]
    private ?int $steps = null;

    #[ORM\ManyToOne]
    #[Groups(['goals'])]
    private ?Item $rewardItem = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['goals'])]
    private ?int $rewardQuantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getSteps(): ?int
    {
        return $this->steps;
    }

    public function setSteps(int $steps): static
    {
        $this->steps = $steps;

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

    public function getRewardQuantity(): ?int
    {
        return $this->rewardQuantity;
    }

    public function setRewardQuantity(?int $rewardQuantity): static
    {
        $this->rewardQuantity = $rewardQuantity;

        return $this;
    }
}
