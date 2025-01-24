<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\ServerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ServerRepository::class)]
#[ORM\Table(name: 'oh_server')]
class Server
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['scenario_show_server', 'server_index', 'server_show', 'character_index', 'character_show', 'hive_index', 'hive_show'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'servers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['server_index', 'character_index', 'character_show', 'hive_index', 'hive_show'])]
    private ?Scenario $scenario = null;

    #[ORM\Column(length: 10)]
    #[Groups(['server_index', 'server_show', 'character_show', 'hive_index', 'hive_show'])]
    private ?string $difficulty = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['server_index', 'server_show'])]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    #[Groups(['scenario_show_server', 'server_index', 'server_show'])]
    private ?bool $closed = null;

    #[ORM\Column(length: 25)]
    #[Groups(['scenario_show_server', 'server_index', 'server_show', 'character_index', 'hive_index', 'hive_show'])]
    private ?string $name = null;

    /**
     * @var Collection<int, ServerTag>
     */
    #[ORM\JoinTable(name: 'oh_server_server_tag')]
    #[ORM\ManyToMany(targetEntity: ServerTag::class)]
    #[Groups(['server_index'])]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScenario(): ?Scenario
    {
        return $this->scenario;
    }

    public function setScenario(?Scenario $scenario): static
    {
        $this->scenario = $scenario;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function isClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): static
    {
        $this->closed = $closed;

        return $this;
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

    /**
     * @return Collection<int, ServerTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(ServerTag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(ServerTag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
