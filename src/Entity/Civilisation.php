<?php

namespace App\Entity;

use App\Repository\CivilisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CivilisationRepository::class)]
class Civilisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 10000)]
    private ?string $description = null;

    #[ORM\Column(length: 1000)]
    private ?string $emplacement = null;

    #[ORM\ManyToMany(targetEntity: Programe::class, inversedBy: 'civilisations')]
    private Collection $programes;

    public function __construct()
    {
        $this->programes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * @return Collection<int, Programe>
     */
    public function getProgrames(): Collection
    {
        return $this->programes;
    }

    public function addPrograme(Programe $programe): static
    {
        if (!$this->programes->contains($programe)) {
            $this->programes->add($programe);
        }

        return $this;
    }

    public function removePrograme(Programe $programe): static
    {
        $this->programes->removeElement($programe);

        return $this;
    }
}
