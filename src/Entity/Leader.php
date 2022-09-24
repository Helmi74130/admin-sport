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


        #[ORM\Column(length: 80)]
        #[Assert\NotBlank()]
        #[Assert\Length(min:2, max:80)]
        private ?string $city = null;

        #[ORM\Column(length: 15)]
        #[Assert\NotBlank()]
        #[Assert\Length(min:10, max:15)]
        private ?string $phone = null;

        #[ORM\Column(length: 5)]
        private ?string $civility = null;

        #[ORM\Column(length: 100)]
        private ?string $email = null;


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
        public function isIsActive(): ?bool
        {
            return $this->isActive;
        }
        public function setIsActive(bool $isActive): self
        {
            $this->isActive = $isActive;
            return $this;
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
        public function getEmail(): ?string
        {
            return $this->email;
        }

        public function setEmail(string $email): self
        {
            $this->email = $email;

            return $this;
        }
    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column]
    private ?bool $isActive = true;
    #[ORM\OneToMany(mappedBy: 'leader', targetEntity: Hall::class, orphanRemoval: true)]
    private Collection $hall;

    #[ORM\OneToOne(mappedBy: 'leader', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'leader', cascade: ['persist', 'remove'])]
    private ?PermissionLeader $permissionLeader = null;

    public function __construct()
    {
        $this->hall = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setLeader(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getLeader() !== $this) {
            $user->setLeader($this);
        }

        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        $test = $this->getHall()->toArray();
        //dd($test);
        if ($test == null){
            return $this->civility.' '.$this->name.' '.$this->firstname.' gère aucune salle pour le moment';
        }else {
            return $this->civility.' '.$this->name.' '.$this->firstname.' gère '.count($test) .' salle(s) pour le moment' ;

            }
    }

    public function getPermissionLeader(): ?PermissionLeader
    {
        return $this->permissionLeader;
    }

    public function setPermissionLeader(?PermissionLeader $permissionLeader): self
    {
        // unset the owning side of the relation if necessary
        if ($permissionLeader === null && $this->permissionLeader !== null) {
            $this->permissionLeader->setLeader(null);
        }

        // set the owning side of the relation if necessary
        if ($permissionLeader !== null && $permissionLeader->getLeader() !== $this) {
            $permissionLeader->setLeader($this);
        }

        $this->permissionLeader = $permissionLeader;

        return $this;
    }

}