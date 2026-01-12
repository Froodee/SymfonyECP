<?php

namespace App\Entity;

use App\Repository\ConnexionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnexionRepository::class)]
class Connexion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $Login = null;

    #[ORM\Column(length: 64)]
    private ?string $Password = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $IDU = null;

    #[ORM\OneToOne(mappedBy: 'IdUserCon', cascade: ['persist', 'remove'])]
    private ?Lien $lien = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->Login;
    }

    public function setLogin(string $Login): static
    {
        $this->Login = $Login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getIDU(): ?int
    {
        return $this->IDU;
    }

    public function setIDU(int $IDU): static
    {
        $this->IDU = $IDU;

        return $this;
    }

    public function getLien(): ?Lien
    {
        return $this->lien;
    }

    public function setLien(?Lien $lien): static
    {
        // unset the owning side of the relation if necessary
        if ($lien === null && $this->lien !== null) {
            $this->lien->setIdUserCon(null);
        }

        // set the owning side of the relation if necessary
        if ($lien !== null && $lien->getIdUserCon() !== $this) {
            $lien->setIdUserCon($this);
        }

        $this->lien = $lien;

        return $this;
    }
}
