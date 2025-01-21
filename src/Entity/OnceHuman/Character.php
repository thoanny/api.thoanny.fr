<?php

namespace App\Entity\OnceHuman;

use App\Entity\User;
use App\Repository\OnceHuman\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: 'oh_character')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $status = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $discordUid = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $ingameUid = null;

    #[ORM\ManyToOne]
    private ?Server $server = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getDiscordUid(): ?string
    {
        return $this->discordUid;
    }

    public function setDiscordUid(?string $discordUid): static
    {
        $this->discordUid = $discordUid;

        return $this;
    }

    public function getIngameUid(): ?string
    {
        return $this->ingameUid;
    }

    public function setIngameUid(?string $ingameUid): static
    {
        $this->ingameUid = $ingameUid;

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $server): static
    {
        $this->server = $server;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
