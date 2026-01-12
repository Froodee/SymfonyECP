<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $NumCde = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateCde = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Utilisateurs $IdUser = null;

    #[ORM\OneToOne(mappedBy: 'NumCde', cascade: ['persist', 'remove'])]
    private ?Facture $facture = null;

    #[ORM\OneToOne(mappedBy: 'NumCde', cascade: ['persist', 'remove'])]
    private ?Panier $panier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCde(): ?int
    {
        return $this->NumCde;
    }

    public function setNumCde(int $NumCde): static
    {
        $this->NumCde = $NumCde;

        return $this;
    }

    public function getDateCde(): ?\DateTime
    {
        return $this->DateCde;
    }

    public function setDateCde(\DateTime $DateCde): static
    {
        $this->DateCde = $DateCde;

        return $this;
    }

    public function getIdUser(): ?Utilisateurs
    {
        return $this->IdUser;
    }

    public function setIdUser(?Utilisateurs $IdUser): static
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): static
    {
        // unset the owning side of the relation if necessary
        if ($facture === null && $this->facture !== null) {
            $this->facture->setNumCde(null);
        }

        // set the owning side of the relation if necessary
        if ($facture !== null && $facture->getNumCde() !== $this) {
            $facture->setNumCde($this);
        }

        $this->facture = $facture;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): static
    {
        // unset the owning side of the relation if necessary
        if ($panier === null && $this->panier !== null) {
            $this->panier->setNumCde(null);
        }

        // set the owning side of the relation if necessary
        if ($panier !== null && $panier->getNumCde() !== $this) {
            $panier->setNumCde($this);
        }

        $this->panier = $panier;

        return $this;
    }
}
