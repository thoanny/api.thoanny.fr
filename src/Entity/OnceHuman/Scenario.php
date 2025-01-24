<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\ScenarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ScenarioRepository::class)]
#[ORM\Table(name: 'oh_scenario')]
class Scenario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item_show_scenario', 'scenario_index', 'scenario_show', 'server_index', 'server_show_scenario', 'character_index', 'character_show', 'hive_index', 'hive_show', 'memetic_index', 'specialization_index'])]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    #[Groups(['item_show_scenario', 'scenario_index', 'scenario_show', 'server_index', 'server_show_scenario', 'character_index', 'character_show', 'hive_index', 'hive_show', 'memetic_index', 'specialization_index'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['scenario_show'])]
    private ?string $description = null;

    /**
     * @var Collection<int, Server>
     */
    #[ORM\OneToMany(targetEntity: Server::class, mappedBy: 'scenario', cascade: ['persist'], orphanRemoval: true)]
    private Collection $servers;

    public function __construct()
    {
        $this->servers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Server>
     */
    public function getServers(): Collection
    {
        return $this->servers;
    }

    public function addServer(Server $server): static
    {
        if (!$this->servers->contains($server)) {
            $this->servers->add($server);
            $server->setScenario($this);
        }

        return $this;
    }

    public function removeServer(Server $server): static
    {
        if ($this->servers->removeElement($server)) {
            // set the owning side to null (unless already changed)
            if ($server->getScenario() === $this) {
                $server->setScenario(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() ?? '';
    }
}
