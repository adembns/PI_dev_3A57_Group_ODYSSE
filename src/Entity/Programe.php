<?php

namespace App\Entity;

use App\Repository\ProgrameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrameRepository::class)]
class Programe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'programes')]
    private ?Resrvation $reservation = null;

    #[ORM\ManyToMany(targetEntity: Civilisation::class, mappedBy: 'programes')]
    private Collection $civilisations;

    public function __construct()
    {
        $this->civilisations = new ArrayCollection();
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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getReservation(): ?Resrvation
    {
        return $this->reservation;
    }

    public function setReservation(?Resrvation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * @return Collection<int, Civilisation>
     */
    public function getCivilisations(): Collection
    {
        return $this->civilisations;
    }

    public function addCivilisation(Civilisation $civilisation): static
    {
        if (!$this->civilisations->contains($civilisation)) {
            $this->civilisations->add($civilisation);
            $civilisation->addPrograme($this);
        }

        return $this;
    }

    public function removeCivilisation(Civilisation $civilisation): static
    {
        if ($this->civilisations->removeElement($civilisation)) {
            $civilisation->removePrograme($this);
        }

        return $this;
    }
}
