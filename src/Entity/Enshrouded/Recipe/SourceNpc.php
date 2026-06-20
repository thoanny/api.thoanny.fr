<?php

namespace App\Entity\Enshrouded\Recipe;

use App\Entity\Enshrouded\Npc;
use App\Repository\Enshrouded\Recipe\SourceNpcRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SourceNpcRepository::class)]
#[ORM\Table(name: 'enshrouded_recipe_source_npc')]
class SourceNpc extends Source
{
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['recipe'])]
    private ?Npc $npc = null;

    public function getNpc(): ?Npc
    {
        return $this->npc;
    }

    public function setNpc(Npc $npc): static
    {
        $this->npc = $npc;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    #[Groups(['recipes', 'recipes_sources'])]
    public function getName(): string
    {
        return $this->getNpc()->getName();
    }
    #[Groups(['recipe', 'recipes', 'recipes_sources'])]
    public function getType(): string
    {
        return 'npc';
    }
}
