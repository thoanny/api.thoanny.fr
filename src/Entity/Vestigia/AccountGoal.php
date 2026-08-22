<?php

namespace App\Entity\Vestigia;

use App\Repository\Vestigia\AccountGoalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AccountGoalRepository::class)]
#[UniqueEntity(fields: ['updatedAt', 'status', 'account'])]
#[ORM\Table(name: '`vestigia_account_goal`')]
class AccountGoal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['me'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 15)]
    #[Groups(['me', 'goal'])]
    private ?string $status = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $account = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['goal'])]
    private ?Goal $goal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getGoal(): ?Goal
    {
        return $this->goal;
    }

    public function setGoal(?Goal $goal): static
    {
        $this->goal = $goal;

        return $this;
    }

    #[Groups(['goal'])]
    public function getDate(): string
    {
        return $this->updatedAt->format('Y-m-d');
    }
}
