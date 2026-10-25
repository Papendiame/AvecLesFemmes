<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre extends Utilisateur
{
    #[ORM\Column(length: 100)]
    private ?string $Fonction = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $Role = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $Groupement = null;

    /**
     * @var Collection<int, ModeCotisation>
     */
    #[ORM\OneToMany(targetEntity: ModeCotisation::class, mappedBy: 'Membre')]
    private Collection $modeCotisations;

    public function __construct()
    {
        $this->modeCotisations = new ArrayCollection();
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

    /**
     * @return Collection<int, ModeCotisation>
     */
    public function getModeCotisations(): Collection
    {
        return $this->modeCotisations;
    }

    // Permissions Symfony selon le rôle métier (Admin / Membre simple)
    public function getRoles(): array
    {
        return match ($this->Role?->getNomRole()) {
            'Admin' => ['ROLE_ADMIN', 'ROLE_USER'],
            default => ['ROLE_MEMBRE', 'ROLE_USER'],
        };
    }
}