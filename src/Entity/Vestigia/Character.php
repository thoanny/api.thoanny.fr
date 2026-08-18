<?php

namespace App\Entity\Vestigia;

use App\Repository\Vestigia\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`vestigia_character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $iteration = null;

    #[ORM\Column]
    private ?bool $dead = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $hpMin = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $hpMax = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $atk = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $def = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $apMin = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $apMax = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $lvl = null;

    #[ORM\Column]
    #[Groups(['me'])]
    private ?int $xp = null;

    #[ORM\ManyToOne(inversedBy: 'characters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Account $account = null;

    #[ORM\Column(length: 5)]
    #[Groups(['me'])]
    private ?string $avatarBody = null;

    #[ORM\Column(length: 5)]
    #[Groups(['me'])]
    private ?string $avatarHead = null;

    #[ORM\Column(length: 5)]
    #[Groups(['me'])]
    private ?string $avatarFace = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Groups(['me'])]
    private ?string $avatarHairs = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Groups(['me'])]
    private ?string $avatarAccessory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIteration(): ?int
    {
        return $this->iteration;
    }

    public function setIteration(int $iteration): static
    {
        $this->iteration = $iteration;

        return $this;
    }

    public function isDead(): ?bool
    {
        return $this->dead;
    }

    public function setDead(bool $dead): static
    {
        $this->dead = $dead;

        return $this;
    }

    public function getHpMin(): ?int
    {
        return $this->hpMin;
    }

    public function setHpMin(int $hpMin): static
    {
        $this->hpMin = $hpMin;

        return $this;
    }

    public function getHpMax(): ?int
    {
        return $this->hpMax;
    }

    public function setHpMax(int $hpMax): static
    {
        $this->hpMax = $hpMax;

        return $this;
    }

    public function getAtk(): ?int
    {
        return $this->atk;
    }

    public function setAtk(int $atk): static
    {
        $this->atk = $atk;

        return $this;
    }

    public function getDef(): ?int
    {
        return $this->def;
    }

    public function setDef(int $def): static
    {
        $this->def = $def;

        return $this;
    }

    public function getApMin(): ?int
    {
        return $this->apMin;
    }

    public function setApMin(int $apMin): static
    {
        $this->apMin = $apMin;

        return $this;
    }

    public function getApMax(): ?int
    {
        return $this->apMax;
    }

    public function setApMax(int $apMax): static
    {
        $this->apMax = $apMax;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(int $lvl): static
    {
        $this->lvl = $lvl;

        return $this;
    }

    public function getXp(): ?int
    {
        return $this->xp;
    }

    public function setXp(int $xp): static
    {
        $this->xp = $xp;

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

    public function getAvatarBody(): ?string
    {
        return $this->avatarBody;
    }

    public function setAvatarBody(string $avatarBody): static
    {
        $this->avatarBody = $avatarBody;

        return $this;
    }

    public function getAvatarHead(): ?string
    {
        return $this->avatarHead;
    }

    public function setAvatarHead(string $avatarHead): static
    {
        $this->avatarHead = $avatarHead;

        return $this;
    }

    public function getAvatarFace(): ?string
    {
        return $this->avatarFace;
    }

    public function setAvatarFace(string $avatarFace): static
    {
        $this->avatarFace = $avatarFace;

        return $this;
    }

    public function getAvatarHairs(): ?string
    {
        return $this->avatarHairs;
    }

    public function setAvatarHairs(?string $avatarHairs): static
    {
        $this->avatarHairs = $avatarHairs;

        return $this;
    }

    public function getAvatarAccessory(): ?string
    {
        return $this->avatarAccessory;
    }

    public function setAvatarAccessory(?string $avatarAccessory): static
    {
        $this->avatarAccessory = $avatarAccessory;

        return $this;
    }
}
