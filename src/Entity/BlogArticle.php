<?php

namespace App\Entity;

use App\Repository\BlogArticleRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use function PHPSTORM_META\type;

#[ORM\Entity(repositoryClass: BlogArticleRepository::class)]
class BlogArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10000)]
    #[Assert\Type("string")]
    #[Assert\NotNull]
    private ?string $contenu = null;

    #[ORM\Column(length: 500)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModify = null;

    #[ORM\Column(length: 255)]

    
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'blogArticles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    #[ORM\OneToMany(targetEntity: BlogComment::class, mappedBy: 'blogArticle')]
    private Collection $blogComments;

    public function __construct() {
        $this->dateCreation = new DateTime();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

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

    /**
     * @return Collection<int, BlogComment>
     */
    public function getBlogComments(): Collection
    {
        return $this->blogComments;
    }

    public function addBlogComment(BlogComment $blogComment): static
    {
        if (!$this->blogComments->contains($blogComment)) {
            $this->blogComments->add($blogComment);
            $blogComment->setBlogArticle($this);
        }

        return $this;
    }

    public function removeBlogComment(BlogComment $blogComment): static
    {
        if ($this->blogComments->removeElement($blogComment)) {
            // set the owning side to null (unless already changed)
            if ($blogComment->getBlogArticle() === $this) {
                $blogComment->setBlogArticle(null);
            }
        }

        return $this;
    }
}
