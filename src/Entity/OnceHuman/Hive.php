<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\HiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HiveRepository::class)]
#[ORM\Table(name: 'oh_hive')]
class Hive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $status = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $leader = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\JoinTable(name: 'oh_hive_member')]
    #[ORM\ManyToMany(targetEntity: Character::class)]
    private Collection $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    public function getLeader(): ?Character
    {
        return $this->leader;
    }

    public function setLeader(?Character $leader): static
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Character $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    public function removeMember(Character $member): static
    {
        $this->members->removeElement($member);

        return $this;
    }
}
