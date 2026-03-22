<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoRepository::class)]
class Promo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateDb = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateFin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $Reduc = null;

    /**
     * @var Collection<int, Produits>
     */
    #[ORM\OneToMany(targetEntity: Produits::class, mappedBy: 'IdPromo')]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function __toString(): string { return 'Promo -' . ($this->Reduc ?? '0') . '% (' . ($this->DateDb?->format('d/m/Y') ?? '') . ')'; }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDb(): ?\DateTime
    {
        return $this->DateDb;
    }

    public function setDateDb(\DateTime $DateDb): static
    {
        $this->DateDb = $DateDb;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTime $DateFin): static
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getReduc(): ?string
    {
        return $this->Reduc;
    }

    public function setReduc(string $Reduc): static
    {
        $this->Reduc = $Reduc;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setIdPromo($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getIdPromo() === $this) {
                $produit->setIdPromo(null);
            }
        }

        return $this;
    }
}
