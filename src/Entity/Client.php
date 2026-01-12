<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $Siret = null;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    private ?Utilisateurs $IdUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiret(): ?string
    {
        return $this->Siret;
    }

    public function setSiret(?string $Siret): static
    {
        $this->Siret = $Siret;

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
