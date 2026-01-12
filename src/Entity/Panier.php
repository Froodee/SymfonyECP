<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Produits>
     */
    #[ORM\OneToMany(targetEntity: Produits::class, mappedBy: 'panier')]
    private Collection $RefPds;

    #[ORM\OneToOne(inversedBy: 'panier', cascade: ['persist', 'remove'])]
    private ?Commande $NumCde = null;

    public function __construct()
    {
        $this->RefPds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getRefPds(): Collection
    {
        return $this->RefPds;
    }

    public function addRefPd(Produits $refPd): static
    {
        if (!$this->RefPds->contains($refPd)) {
            $this->RefPds->add($refPd);
            $refPd->setPanier($this);
        }

        return $this;
    }

    public function removeRefPd(Produits $refPd): static
    {
        if ($this->RefPds->removeElement($refPd)) {
            // set the owning side to null (unless already changed)
            if ($refPd->getPanier() === $this) {
                $refPd->setPanier(null);
            }
        }

        return $this;
    }

    public function getNumCde(): ?Commande
    {
        return $this->NumCde;
    }

    public function setNumCde(?Commande $NumCde): static
    {
        $this->NumCde = $NumCde;

        return $this;
    }
}
