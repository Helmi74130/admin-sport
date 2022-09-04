<?php
namespace App\Entity;
use App\Repository\LeaderRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[UniqueEntity('email')]
#[UniqueEntity(fields: ['email'], message: 'Un compte existe déja avec cette adresse mail')]
#[ORM\Entity(repositoryClass: LeaderRepository::class)]
class Leader implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Assert\Email()]
    #[Assert\Length(min:2, max:50)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 80)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:80)]
    private ?string $city = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:10, max:15)]
    private ?string $phone = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Length(min:10, max:15)]
    private ?string $commercialPhone = null;

    #[ORM\Column]
    private ?bool $isActive = true;
    #[ORM\OneToMany(mappedBy: 'leader', targetEntity: Hall::class, orphanRemoval: true)]
    private Collection $hall;

    #[ORM\Column(length: 5)]
    private ?string $civility = null;

    public function __construct()
    {
        $this->hall = new ArrayCollection();
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
        $roles[] = 'ROLE_LEADER';

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
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
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
    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(string $city): self
    {
        $this->city = $city;
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
    public function getCommercialPhone(): ?string
    {
        return $this->commercialPhone;
    }
    public function setCommercialPhone(?string $commercialPhone): self
    {
        $this->commercialPhone = $commercialPhone;
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
    /**
     * @return Collection<int, Hall>
     */
    public function getHall(): Collection
    {
        return $this->hall;
    }
    public function addHall(Hall $hall): self
    {
        if (!$this->hall->contains($hall)) {
            $this->hall->add($hall);
            $hall->setLeader($this);
        }
        return $this;
    }
    public function removeHall(Hall $hall): self
    {
        if ($this->hall->removeElement($hall)) {
            // set the owning side to null (unless already changed)
            if ($hall->getLeader() === $this) {
                $hall->setLeader(null);
            }
        }
        return $this;
    }
    public function __toString()
    {
        return $this->name.' '.$this->firstname;
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
}