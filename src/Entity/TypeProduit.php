<?php

namespace App\Entity;

use App\Repository\TypeProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeProduitRepository::class)]
class TypeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $CodeTyp = null;

    #[ORM\Column(length: 255)]
    private ?string $LibTyp = null;

    /**
     * @var Collection<int, Produits>
     */
    #[ORM\OneToMany(targetEntity: Produits::class, mappedBy: 'CodeTyp')]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeTyp(): ?int
    {
        return $this->CodeTyp;
    }

    public function setCodeTyp(int $CodeTyp): static
    {
        $this->CodeTyp = $CodeTyp;

        return $this;
    }

    public function getLibTyp(): ?string
    {
        return $this->LibTyp;
    }

    public function setLibTyp(string $LibTyp): static
    {
        $this->LibTyp = $LibTyp;

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
            $produit->setCodeTyp($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCodeTyp() === $this) {
                $produit->setCodeTyp(null);
            }
        }

        return $this;
    }
}
