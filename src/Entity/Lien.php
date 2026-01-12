<?php

namespace App\Entity;

use App\Repository\LienRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LienRepository::class)]
class Lien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'lien', cascade: ['persist', 'remove'])]
    private ?connexion $IdUserCon = null;

    #[ORM\OneToOne(inversedBy: 'lien', cascade: ['persist', 'remove'])]
    private ?Utilisateurs $IdUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUserCon(): ?connexion
    {
        return $this->IdUserCon;
    }

    public function setIdUserCon(?connexion $IdUserCon): static
    {
        $this->IdUserCon = $IdUserCon;

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
