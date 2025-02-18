<?php

namespace App\Entity\PressReview;

use App\Repository\PressReview\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: 'pr_post')]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['issue_show_posts', 'automation_index'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['issue_show_posts'])]
    private ?string $title = null;

    #[ORM\Column(length: 55, nullable: true)]
    #[Groups(['issue_show_posts'])]
    private ?string $source = null;

    #[ORM\Column(length: 255)]
    #[Groups(['issue_show_posts', 'automation_index'])]
    private ?string $link = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['issue_show_posts'])]
    private ?string $thumbnail = null;

    #[ORM\Column]
    #[Groups(['issue_show_posts'])]
    private ?\DateTimeImmutable $published_at = null;

    #[ORM\Column(length: 45)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['issue_show_posts'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $lvl = null;

    #[ORM\Column(length: 40, unique: true)]
    private ?string $uid = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Issue $issue = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\JoinTable(name: 'pr_post_tag')]
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'posts')]
    #[Groups(['issue_show_posts'])]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeImmutable $published_at): static
    {
        $this->published_at = $published_at;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(?int $lvl): static
    {
        $this->lvl = $lvl;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getIssue(): ?Issue
    {
        return $this->issue;
    }

    public function setIssue(?Issue $issue): static
    {
        $this->issue = $issue;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
