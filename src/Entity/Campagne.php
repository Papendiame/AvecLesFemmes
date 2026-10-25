<?php

namespace App\Entity;

use App\Repository\CampagneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
class Campagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $DateDebut = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $DateFin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private ?string $Montant = null;

    // Type de campagne (Tontine / Epargne) : relation optionnelle (zeroOrManyToOne)
    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Type $Type = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $Groupement = null;

    /**
     * @var Collection<int, ModeCotisation>
     */
    #[ORM\OneToMany(targetEntity: ModeCotisation::class, mappedBy: 'Campagne', orphanRemoval: true)]
    private Collection $modeCotisations;

    public function __construct()
    {
        $this->modeCotisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeImmutable $DateDebut): static
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeImmutable $DateFin): static
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->Montant;
    }

    public function setMontant(string $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->Type;
    }

    public function setType(?Type $Type): static
    {
        $this->Type = $Type;

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

    public function addModeCotisation(ModeCotisation $modeCotisation): static
    {
        if (!$this->modeCotisations->contains($modeCotisation)) {
            $this->modeCotisations->add($modeCotisation);
            $modeCotisation->setCampagne($this);
        }

        return $this;
    }

    public function removeModeCotisation(ModeCotisation $modeCotisation): static
    {
        if ($this->modeCotisations->removeElement($modeCotisation)) {
            if ($modeCotisation->getCampagne() === $this) {
                $modeCotisation->setCampagne(null);
            }
        }

        return $this;
    }
}