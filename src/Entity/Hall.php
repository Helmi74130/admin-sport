<?php

namespace App\Entity;

use App\Repository\HallRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('name')]
#[ORM\Entity(repositoryClass: HallRepository::class)]
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
