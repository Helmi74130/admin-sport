<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cette adresse e-mail est déja associée à un compte')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min:2, max:180)]
    private ?string $email = null;

    #[ORM\Column(nullable: false)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:50)]
    protected ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:50)]
    protected ?string $name = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;


    #[ORM\Column(length: 5)]
    protected ?string $civility = null;

    #[ORM\Column(length: 15)]
    private ?string $phone = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?Leader $leader = null;

    #[ORM\Column(length: 100)]
    private ?string $city = null;


    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?LeaderHall $leaderHall = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
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


    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }


    public function __toString()
    {
        foreach ($this->roles as $role) {
            if($role === 'ROLE_USER'){
                $salle = 'Gérant de Salle';
            }else{
                $salle = 'Gérant de Franchise';
            }
        }
        return $this->civility.' '.$this->name.' '.$this->firstname;
    }


   public function getCivility(): ?string
   {
       return $this->civility;
   }

   public function setCivility(string $civility): self
   {
       $this->civility = $civility;

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


   public function getLeader(): ?Leader
   {
       return $this->leader;
   }

   public function setLeader(?Leader $leader): self
   {
       $this->leader = $leader;

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


   public function isIsActive(): ?bool
   {
       return $this->isActive;
   }

   public function setIsActive(bool $isActive): self
   {
       $this->isActive = $isActive;

       return $this;
   }

   public function getLeaderHall(): ?LeaderHall
   {
       return $this->leaderHall;
   }

   public function setLeaderHall(?LeaderHall $leaderHall): self
   {
       $this->leaderHall = $leaderHall;

       return $this;
   }


}