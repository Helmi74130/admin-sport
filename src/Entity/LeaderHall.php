<?php

namespace App\Entity;

use App\Repository\LeaderHallRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeaderHallRepository::class)]
class LeaderHall
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

        #[ORM\Column(length: 50)]
        private ?string $name = null;

        #[ORM\Column(length: 50)]
        private ?string $firstname = null;

        #[ORM\Column(length: 80)]
        private ?string $city = null;

        #[ORM\Column(length: 15)]
        private ?string $phone = null;

       #[ORM\Column]
        private ?bool $isActive = null;

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

    #[ORM\OneToOne(inversedBy: 'leaderHall', cascade: ['persist', 'remove'])]
    private ?Hall $hall = null;

    #[ORM\OneToOne(mappedBy: 'leaderHall', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setLeaderHall(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getLeaderHall() !== $this) {
            $user->setLeaderHall($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall):self
    {
        if ($this->hall == null){
            $this->hall = $hall;
            return $this;
        }return $this;


    }

    public function __toString()
    {

        if ($this->hall == null){
            return $this->civility.' '.$this->name.' '.$this->firstname;
        }else {
            return $this->civility.' '.$this->name.' '.$this->firstname.' possède déja la salle'.' '.$this->hall ;
        }

    }

}
