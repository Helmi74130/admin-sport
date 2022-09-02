<?php

namespace App\Entity;

use App\Repository\HallRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[UniqueEntity('name')]
#[ORM\Entity(repositoryClass: HallRepository::class)]
#[Vich\Uploadable]
class Hall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:150)]
    private ?string $name = null;

    #[Vich\UploadableField(mapping: 'hall_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $streetNumber = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $adress = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:150)]
    private ?string $city = null;

    #[ORM\Column]
    private ?bool $isactive = true;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $phone = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank()]
    private ?string $postalCode = null;

    #[ORM\OneToOne(mappedBy: 'hall', cascade: ['persist', 'remove'])]
    private ?Permission $permissions = null;

    #[ORM\ManyToOne(inversedBy: 'hall')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Leader $leader = null;

    #[ORM\ManyToOne(inversedBy: 'hall')]
    //#[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function isIsactive(): ?bool
    {
        return $this->isactive;
    }

    public function setIsactive(bool $isactive): self
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }


   public function getPermissions(): ?Permission
   {
       return $this->permissions;
   }

   public function setPermissions(Permission $permissions): self
   {
       // set the owning side of the relation if necessary
       if ($permissions->getHall() !== $this) {
           $permissions->setHall($this);
       }

       $this->permissions = $permissions;

       return $this;
   }

   public function getLeader(): ?Leader
   {
       return $this->leader;
   }

   public function setLeader(?Leader $leader): self
   {
       $this->leader = $leader;

       return $this;
   }

    public function __toString()
    {
        return $this->name;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
