<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\SpecializationGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecializationGroupRepository::class)]
#[ORM\Table(name: 'oh_specialization_group')]
class SpecializationGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $name = null;

    /**
     * @var Collection<int, Specialization>
     */
    #[ORM\JoinTable(name: 'oh_specialization_group_specialization')]
    #[ORM\ManyToMany(targetEntity: Specialization::class)]
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
