<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'oh_event')]
#[Vich\Uploadable]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['event_index'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['event_index'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['event_index'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['event_index'])]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['event_index'])]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    #[Groups(['event_index'])]
    private ?bool $allDay = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['event_index'])]
    private ?string $url = null;

    #[Vich\UploadableField(mapping: 'oh_events', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

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

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function isAllDay(): ?bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): static
    {
        $this->allDay = $allDay;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    #[Groups(['event_index'])]
    public function getImageUrl(): ?string
    {
        $root = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/images/once-human/events/';
        return $this->image ? $root.$this->image : null;
    }
}
