<?php
namespace App\Entity;
use App\Repository\LeaderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LeaderRepository::class)]
class Leader
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
    private ?string $mail = null;

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
    public function __construct()
    {
        $this->hall = new ArrayCollection();
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
    public function getMail(): ?string
    {
        return $this->mail;
    }
    public function setMail(string $mail): self
    {
        $this->mail = $mail;
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
}