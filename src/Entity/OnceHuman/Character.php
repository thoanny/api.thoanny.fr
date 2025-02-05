<?php

namespace App\Entity\OnceHuman;

use App\Entity\User;
use App\Repository\OnceHuman\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: 'oh_character')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['character_index', 'character_show', 'hive_show', 'user_character_index', 'user_character_specialization'])]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    #[Groups(['character_index', 'character_show', 'hive_index', 'hive_show', 'user_character_index', 'user_character_specialization'])]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Groups(['user_character_index'])]
    private ?string $status = null;

    #[ORM\Column(length: 45, nullable: true)]
    #[Groups(['user_character_index'])]
    private ?string $discordUid = null;

    #[ORM\Column(length: 45, nullable: true)]
    #[Groups(['user_character_index'])]
    private ?string $ingameUid = null;

    #[ORM\ManyToOne]
    #[Groups(['character_index', 'character_show', 'hive_index', 'hive_show', 'user_character_index'])]
    private ?Server $server = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Specialization>
     */
    #[ORM\ManyToMany(targetEntity: Specialization::class)]
    #[ORM\JoinTable(name: 'oh_character_specialization')]
    #[Groups(['user_character_specialization'])]
    private Collection $specializations;

    public function __construct()
    {
        $this->specializations = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Specialization>
     */
    public function getSpecializations(): Collection
    {
        return $this->specializations;
    }

    public function addSpecialization(Specialization $specialization): static
    {
        if (!$this->specializations->contains($specialization)) {
            $this->specializations->add($specialization);
        }

        return $this;
    }

    public function removeSpecialization(Specialization $specialization): static
    {
        $this->specializations->removeElement($specialization);

        return $this;
    }
}
