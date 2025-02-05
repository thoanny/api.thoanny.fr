<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\SpecializationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SpecializationRepository::class)]
#[ORM\Table(name: 'oh_specialization')]
#[Vich\Uploadable]
class Specialization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['specialization_index', 'user_character_specialization'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['specialization_index'])]
    private ?string $name = null;

    #[ORM\Column(length: 55, nullable: true)]
    #[Groups(['specialization_index'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['specialization_index'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['specialization_index'])]
    private ?array $levels = null;

    /**
     * @var Collection<int, Scenario>
     */
    #[ORM\JoinTable(name: 'oh_specialization_scenario')]
    #[ORM\ManyToMany(targetEntity: Scenario::class)]
    #[Groups(['specialization_index'])]
    private Collection $scenarios;

    #[Vich\UploadableField(mapping: 'oh_specializations', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->scenarios = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

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

    public function getLevels(): ?array
    {
        return $this->levels;
    }

    public function setLevels(?array $levels): static
    {
        $this->levels = $levels;

        return $this;
    }

    /**
     * @return Collection<int, Scenario>
     */
    public function getScenarios(): Collection
    {
        return $this->scenarios;
    }

    public function addScenario(Scenario $scenario): static
    {
        if (!$this->scenarios->contains($scenario)) {
            $this->scenarios->add($scenario);
        }

        return $this;
    }

    public function removeScenario(Scenario $scenario): static
    {
        $this->scenarios->removeElement($scenario);

        return $this;
    }

    public function setIconFile(?File $iconFile = null): void
    {
        $this->iconFile = $iconFile;

        if (null !== $iconFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIconFile(): ?File
    {
        return $this->iconFile;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    #[Groups(['specialization_index'])]
    public function getIconUrl(): ?string
    {
        $root = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/images/once-human/specializations/';
        return $this->icon ? $root.$this->icon : null;
    }
}
