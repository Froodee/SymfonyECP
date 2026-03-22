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

    #[ORM\Column(type: 'smallint')]
    private int $note = 5;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Produits $RefPds = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    private ?Utilisateurs $IdUser = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): int { return $this->note; }
    public function setNote(int $note): static { $this->note = max(1, min(5, $note)); return $this; }

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

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }

    public function getNomAuteur(): string
    {
        if ($this->IdUser) return $this->IdUser->getNomUser();
        if ($this->user)   return $this->user->getUserIdentifier();
        return 'Anonyme';
    }
}
