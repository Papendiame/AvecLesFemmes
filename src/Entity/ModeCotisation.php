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

    #[ORM\ManyToOne(inversedBy: 'modeCotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campagne $Campagne = null;

    #[ORM\ManyToOne(inversedBy: 'modeCotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $Membre = null;

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

    public function getCampagne(): ?Campagne
    {
        return $this->Campagne;
    }

    public function setCampagne(?Campagne $Campagne): static
    {
        $this->Campagne = $Campagne;

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->Membre;
    }

    public function setMembre(?Membre $Membre): static
    {
        $this->Membre = $Membre;

        return $this;
    }
}