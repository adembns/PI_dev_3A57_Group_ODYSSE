<?php

namespace App\Entity;

use App\Repository\ResrvationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResrvationRepository::class)]
class Resrvation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateReservation = null;

    #[ORM\ManyToOne(inversedBy: 'resrvations')]
    private ?User $users = null;

    #[ORM\OneToMany(targetEntity: Programe::class, mappedBy: 'reservation')]
    private Collection $programes;

    #[ORM\OneToOne(mappedBy: 'reservation', cascade: ['persist', 'remove'])]
    private ?Reclamation $reclamation = null;

    #[ORM\ManyToOne(inversedBy: 'resrvations')]
    private ?Hotel $hotel = null;

    #[ORM\ManyToOne(inversedBy: 'resrvations')]
    private ?Restaurant $restaurant = null;

    #[ORM\ManyToOne(inversedBy: 'resrvations')]
    private ?Evenement $evenement = null;
    
    public function __construct()
    {
        $this->programes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): static
    {
        $this->dateReservation = $dateReservation;

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
            $programe->setReservation($this);
        }

        return $this;
    }

    public function removePrograme(Programe $programe): static
    {
        if ($this->programes->removeElement($programe)) {
            // set the owning side to null (unless already changed)
            if ($programe->getReservation() === $this) {
                $programe->setReservation(null);
            }
        }

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(Reclamation $reclamation): static
    {
        // set the owning side of the relation if necessary
        if ($reclamation->getReservation() !== $this) {
            $reclamation->setReservation($this);
        }

        $this->reclamation = $reclamation;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): static
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }

    

    
}
