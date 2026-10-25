<?php

namespace App\Entity;

use App\Repository\ModeCotisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModeCotisationRepository::class)]
class ModeCotisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $Libre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLibre(): ?bool
    {
        return $this->Libre;
    }

    public function setLibre(bool $Libre): static
    {
        $this->Libre = $Libre;

        return $this;
    }
}
