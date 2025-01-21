<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\MemeticCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MemeticCategoryRepository::class)]
#[ORM\Table(name: 'oh_memetic_category')]
class MemeticCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['memetic_index'])]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    /**
     * @var Collection<int, Memetic>
     */
    #[ORM\OneToMany(targetEntity: Memetic::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $memetics;

    public function __construct()
    {
        $this->memetics = new ArrayCollection();
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
     * @return Collection<int, Memetic>
     */
    public function getMemetics(): Collection
    {
        return $this->memetics;
    }

    public function addMemetic(Memetic $memetic): static
    {
        if (!$this->memetics->contains($memetic)) {
            $this->memetics->add($memetic);
            $memetic->setCategory($this);
        }

        return $this;
    }

    public function removeMemetic(Memetic $memetic): static
    {
        if ($this->memetics->removeElement($memetic)) {
            // set the owning side to null (unless already changed)
            if ($memetic->getCategory() === $this) {
                $memetic->setCategory(null);
            }
        }

        return $this;
    }
}
