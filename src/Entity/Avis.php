<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Produits $RefPds = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Utilisateurs $IdUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(string $Commentaire): static
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

    public function getRefPds(): ?Produits
    {
        return $this->RefPds;
    }

    public function setRefPds(?Produits $RefPds): static
    {
        $this->RefPds = $RefPds;

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
}
