<?php

namespace App\Entity;

use App\Repository\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isSellDrinks = null;

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
}
