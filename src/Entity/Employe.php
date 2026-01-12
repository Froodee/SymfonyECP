<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 13)]
    private ?string $NoSecu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateEmp = null;

    #[ORM\OneToOne(inversedBy: 'employe', cascade: ['persist', 'remove'])]
    private ?Utilisateurs $IdUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoSecu(): ?string
    {
        return $this->NoSecu;
    }

    public function setNoSecu(string $NoSecu): static
    {
        $this->NoSecu = $NoSecu;

        return $this;
    }

    public function getDateEmp(): ?\DateTime
    {
        return $this->DateEmp;
    }

    public function setDateEmp(\DateTime $DateEmp): static
    {
        $this->DateEmp = $DateEmp;

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
