<?php

namespace App\Entity;

use App\Repository\PermissionLeaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionLeaderRepository::class)]
class PermissionLeader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isSellDrinks = true;

    #[ORM\Column]
    private ?bool $isMembersWrite = true;

    #[ORM\Column]
    private ?bool $isMembersRead = true;

    #[ORM\Column]
    private ?bool $isMembersAdd = true;

    #[ORM\Column]
    private ?bool $isMembersStatistiqueRead = true;

    #[ORM\Column]
    private ?bool $isPaymentSchedulesWrite = true;

    #[ORM\Column]
    private ?bool $isPaymentSchedulesAdd = true;

    #[ORM\OneToOne(inversedBy: 'permissionLeader', cascade: ['persist', 'remove'])]
    private ?Leader $leader = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsSellDrinks(): ?bool
    {
        return $this->isSellDrinks;
    }

    public function setIsSellDrinks(bool $isSellDrinks): self
    {
        $this->isSellDrinks = $isSellDrinks;

        return $this;
    }

    public function isIsMembersWrite(): ?bool
    {
        return $this->isMembersWrite;
    }

    public function setIsMembersWrite(bool $isMembersWrite): self
    {
        $this->isMembersWrite = $isMembersWrite;

        return $this;
    }

    public function isIsMembersRead(): ?bool
    {
        return $this->isMembersRead;
    }

    public function setIsMembersRead(bool $isMembersRead): self
    {
        $this->isMembersRead = $isMembersRead;

        return $this;
    }

    public function isIsMembersAdd(): ?bool
    {
        return $this->isMembersAdd;
    }

    public function setIsMembersAdd(bool $isMembersAdd): self
    {
        $this->isMembersAdd = $isMembersAdd;

        return $this;
    }

    public function isIsMembersStatistiqueRead(): ?bool
    {
        return $this->isMembersStatistiqueRead;
    }

    public function setIsMembersStatistiqueRead(bool $isMembersStatistiqueRead): self
    {
        $this->isMembersStatistiqueRead = $isMembersStatistiqueRead;

        return $this;
    }

    public function isIsPaymentSchedulesWrite(): ?bool
    {
        return $this->isPaymentSchedulesWrite;
    }

    public function setIsPaymentSchedulesWrite(bool $isPaymentSchedulesWrite): self
    {
        $this->isPaymentSchedulesWrite = $isPaymentSchedulesWrite;

        return $this;
    }

    public function isIsPaymentSchedulesAdd(): ?bool
    {
        return $this->isPaymentSchedulesAdd;
    }

    public function setIsPaymentSchedulesAdd(bool $isPaymentSchedulesAdd): self
    {
        $this->isPaymentSchedulesAdd = $isPaymentSchedulesAdd;

        return $this;
    }


    public function __toString()
    {
        return $this->id;
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

}
