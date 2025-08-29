<?php

namespace App\Entity\Blog;

use App\Repository\Blog\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: 'blog_tag')]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['post_show', 'tag_show'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['post_show', 'tag_show'])]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Slug(fields: ['name'])]
    #[Groups(['post_show', 'tag_show'])]
    private ?string $slug = null;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'tags')]
    private Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): static
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->addTag($this);
        }

        return $this;
    }

    public function removePost(Post $post): static
    {
        if ($this->posts->removeElement($post)) {
            $post->removeTag($this);
        }

        return $this;
    }
}
