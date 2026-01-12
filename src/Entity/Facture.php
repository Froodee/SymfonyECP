<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $NumFact = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateFact = null;

    #[ORM\OneToOne(inversedBy: 'facture', cascade: ['persist', 'remove'])]
    private ?Commande $NumCde = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFact(): ?int
    {
        return $this->NumFact;
    }

    public function setNumFact(int $NumFact): static
    {
        $this->NumFact = $NumFact;

        return $this;
    }

    public function getDateFact(): ?\DateTime
    {
        return $this->DateFact;
    }

    public function setDateFact(\DateTime $DateFact): static
    {
        $this->DateFact = $DateFact;

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
