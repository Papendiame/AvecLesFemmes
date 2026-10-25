<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Fonction = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ModeCotisation $ModeCotisation = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $Role = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $Groupement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFonction(): ?string
    {
        return $this->Fonction;
    }

    public function setFonction(string $Fonction): static
    {
        $this->Fonction = $Fonction;

        return $this;
    }

    public function getModeCotisation(): ?ModeCotisation
    {
        return $this->ModeCotisation;
    }

    public function setModeCotisation(?ModeCotisation $ModeCotisation): static
    {
        $this->ModeCotisation = $ModeCotisation;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->Role;
    }

    public function setRole(?Role $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    public function getGroupement(): ?Groupement
    {
        return $this->Groupement;
    }

    public function setGroupement(?Groupement $Groupement): static
    {
        $this->Groupement = $Groupement;

        return $this;
    }
}
