<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
#[ORM\Table(name: 'rendez_vous')]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Veuillez entrer votre nom.')]
    #[Assert\Length(max: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'Veuillez entrer votre email.')]
    #[Assert\Email(message: 'Adresse email invalide.')]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Veuillez entrer votre numéro de téléphone.')]
    private ?string $telephone = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Veuillez choisir un service.')]
    private ?string $service = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: 'Veuillez choisir une date et heure.')]
    #[Assert\GreaterThan('today', message: 'La date doit être dans le futur.')]
    private ?\DateTimeInterface $dateRdv = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Assert\Length(max: 500)]
    private ?string $message = null;

    #[ORM\Column(length: 20)]
    private string $statut = 'en_attente';

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int { return $this->id; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): static { $this->nom = $nom; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(string $telephone): static { $this->telephone = $telephone; return $this; }

    public function getService(): ?string { return $this->service; }
    public function setService(string $service): static { $this->service = $service; return $this; }

    public function getDateRdv(): ?\DateTimeInterface { return $this->dateRdv; }
    public function setDateRdv(\DateTimeInterface $dateRdv): static { $this->dateRdv = $dateRdv; return $this; }

    public function getMessage(): ?string { return $this->message; }
    public function setMessage(?string $message): static { $this->message = $message; return $this; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $statut): static { $this->statut = $statut; return $this; }

    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $createdAt): static { $this->createdAt = $createdAt; return $this; }
}
