<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $RefPds = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Qtepds = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $PrixPds = null;

    #[ORM\Column(length: 32)]
    private ?string $LibPds = null;

    #[ORM\Column(length: 512)]
    private ?string $DescPds = null;

    #[ORM\Column(length: 255)]
    private ?string $DesignPds = null;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'RefPds')]
    private Collection $avis;

    #[ORM\ManyToOne(inversedBy: 'RefPds')]
    private ?Panier $panier = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Promo $IdPromo = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?TypeProduit $CodeTyp = null;

    #[ORM\Column]
    private bool $estReglemente = false;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefPds(): ?int
    {
        return $this->RefPds;
    }

    public function setRefPds(int $RefPds): static
    {
        $this->RefPds = $RefPds;

        return $this;
    }

    public function getQtepds(): ?int
    {
        return $this->Qtepds;
    }

    public function setQtepds(int $Qtepds): static
    {
        $this->Qtepds = $Qtepds;

        return $this;
    }

    public function getPrixPds(): ?string
    {
        return $this->PrixPds;
    }

    public function setPrixPds(string $PrixPds): static
    {
        $this->PrixPds = $PrixPds;

        return $this;
    }

    public function getLibPds(): ?string
    {
        return $this->LibPds;
    }

    public function setLibPds(string $LibPds): static
    {
        $this->LibPds = $LibPds;

        return $this;
    }

    public function getDescPds(): ?string
    {
        return $this->DescPds;
    }

    public function setDescPds(string $DescPds): static
    {
        $this->DescPds = $DescPds;

        return $this;
    }

    public function getDesignPds(): ?string
    {
        return $this->DesignPds;
    }

    public function setDesignPds(string $DesignPds): static
    {
        $this->DesignPds = $DesignPds;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setRefPds($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getRefPds() === $this) {
                $avi->setRefPds(null);
            }
        }

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }

    public function getIdPromo(): ?Promo
    {
        return $this->IdPromo;
    }

    public function setIdPromo(?Promo $IdPromo): static
    {
        $this->IdPromo = $IdPromo;

        return $this;
    }

    public function getCodeTyp(): ?TypeProduit
    {
        return $this->CodeTyp;
    }

    public function setCodeTyp(?TypeProduit $CodeTyp): static
    {
        $this->CodeTyp = $CodeTyp;

        return $this;
    }

    public function isEstReglemente(): bool
    {
        return $this->estReglemente;
    }

    public function setEstReglemente(bool $estReglemente): static
    {
        $this->estReglemente = $estReglemente;

        return $this;
    }
}
