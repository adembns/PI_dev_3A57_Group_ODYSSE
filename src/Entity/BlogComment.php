<?php

namespace App\Entity;

use App\Repository\BlogCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogCommentRepository::class)]
class BlogComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10000)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModify = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'blogComments')]
    private ?self $blogArticle = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'blogArticle')]
    private Collection $blogComments;

    #[ORM\ManyToOne(inversedBy: 'blogComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    public function __construct()
    {
        $this->blogComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateModify(): ?\DateTimeInterface
    {
        return $this->dateModify;
    }

    public function setDateModify(?\DateTimeInterface $dateModify): static
    {
        $this->dateModify = $dateModify;

        return $this;
    }

    public function getBlogArticle(): ?self
    {
        return $this->blogArticle;
    }

    public function setBlogArticle(?self $blogArticle): static
    {
        $this->blogArticle = $blogArticle;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getBlogComments(): Collection
    {
        return $this->blogComments;
    }

    public function addBlogComment(self $blogComment): static
    {
        if (!$this->blogComments->contains($blogComment)) {
            $this->blogComments->add($blogComment);
            $blogComment->setBlogArticle($this);
        }

        return $this;
    }

    public function removeBlogComment(self $blogComment): static
    {
        if ($this->blogComments->removeElement($blogComment)) {
            // set the owning side to null (unless already changed)
            if ($blogComment->getBlogArticle() === $this) {
                $blogComment->setBlogArticle(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }
}
