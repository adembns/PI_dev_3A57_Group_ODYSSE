<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: HotelRepository::class)]
#[Vich\Uploadable]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\OneToMany(targetEntity: Resrvation::class, mappedBy: 'hotel')]
    private Collection $resrvations;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message : 'Ce champ est obligatoire')]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message : 'Ce champ est obligatoire')]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message : 'Ce champ est obligatoire')]
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message : 'Ce champ est obligatoire')]
    private ?string $features = null;

    #[Vich\UploadableField(mapping: 'restaurant_directory', fileNameProperty: 'imageName')]
    #[Assert\NotBlank(message : 'Ce champ est obligatoire')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    public function __construct()
    {
        $this->resrvations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    

    /**
     * @return Collection<int, Resrvation>
     */
    public function getResrvations(): Collection
    {
        return $this->resrvations;
    }

    public function addResrvation(Resrvation $resrvation): static
    {
        if (!$this->resrvations->contains($resrvation)) {
            $this->resrvations->add($resrvation);
            $resrvation->setHotel($this);
        }

        return $this;
    }

    public function removeResrvation(Resrvation $resrvation): static
    {
        if ($this->resrvations->removeElement($resrvation)) {
            // set the owning side to null (unless already changed)
            if ($resrvation->getHotel() === $this) {
                $resrvation->setHotel(null);
            }
        }

        return $this;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getFeatures(): ?string
    {
        return $this->features;
    }

    public function setFeatures(string $features): static
    {
        $this->features = $features;

        return $this;
    }

    /**
      * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
      * of 'UploadedFile' is injected into this setter to trigger the update. If this
      * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
      * must be able to accept an instance of 'File' as the bundle will inject one here
      * during Doctrine hydration.
      *
      * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
      */
// Image Uploder :

public function setImageFile(?File $imageFile = null): void
{
    $this->imageFile = $imageFile;

    if (null !== $imageFile) {
        // It is required that at least one field changes if you are using doctrine
        // otherwise the event listeners won't be called and the file is lost
        $this->updatedAt = new \DateTimeImmutable();
    }
}

public function getImageFile(): ?File
{
    return $this->imageFile;
}

public function setImageName(?string $imageName): void
{
    $this->imageName = $imageName;
}

public function getImageName(): ?string
{
    return $this->imageName;
}

   
}
