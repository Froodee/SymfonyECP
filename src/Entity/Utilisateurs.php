<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateursRepository::class)]
class Utilisateurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $IdUser = null;

    #[ORM\Column(length: 64)]
    private ?string $NomUser = null;

    #[ORM\Column(length: 64)]
    private ?string $AdrUser = null;

    #[ORM\Column(length: 5)]
    private ?string $CpUser = null;

    #[ORM\Column(length: 64)]
    private ?string $VilleUser = null;

    #[ORM\Column(length: 10)]
    private ?string $NumUser = null;

    #[ORM\Column(length: 255)]
    private ?string $EmailUser = null;

    #[ORM\OneToOne(mappedBy: 'IdUser', cascade: ['persist', 'remove'])]
    private ?Employe $employe = null;

    #[ORM\OneToOne(mappedBy: 'IdUser', cascade: ['persist', 'remove'])]
    private ?Client $client = null;

    #[ORM\OneToOne(mappedBy: 'IdUser', cascade: ['persist', 'remove'])]
    private ?Admin $admin = null;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'IdUser')]
    private Collection $avis;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'IdUser')]
    private Collection $commandes;

    #[ORM\OneToOne(mappedBy: 'IdUser', cascade: ['persist', 'remove'])]
    private ?Lien $lien = null;

    #[ORM\OneToOne(mappedBy: 'Utilisateur', cascade: ['persist', 'remove'])]
    private ?User $utilisateurUser = null;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function __toString(): string { return $this->NomUser ?? ''; }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->IdUser;
    }

    public function setIdUser(int $IdUser): static
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    public function getNomUser(): ?string
    {
        return $this->NomUser;
    }

    public function setNomUser(string $NomUser): static
    {
        $this->NomUser = $NomUser;

        return $this;
    }

    public function getAdrUser(): ?string
    {
        return $this->AdrUser;
    }

    public function setAdrUser(string $AdrUser): static
    {
        $this->AdrUser = $AdrUser;

        return $this;
    }

    public function getCpUser(): ?string
    {
        return $this->CpUser;
    }

    public function setCpUser(string $CpUser): static
    {
        $this->CpUser = $CpUser;

        return $this;
    }

    public function getVilleUser(): ?string
    {
        return $this->VilleUser;
    }

    public function setVilleUser(string $VilleUser): static
    {
        $this->VilleUser = $VilleUser;

        return $this;
    }

    public function getNumUser(): ?string
    {
        return $this->NumUser;
    }

    public function setNumUser(string $NumUser): static
    {
        $this->NumUser = $NumUser;

        return $this;
    }

    public function getEmailUser(): ?string
    {
        return $this->EmailUser;
    }

    public function setEmailUser(string $EmailUser): static
    {
        $this->EmailUser = $EmailUser;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): static
    {
        // unset the owning side of the relation if necessary
        if ($employe === null && $this->employe !== null) {
            $this->employe->setIdUser(null);
        }

        // set the owning side of the relation if necessary
        if ($employe !== null && $employe->getIdUser() !== $this) {
            $employe->setIdUser($this);
        }

        $this->employe = $employe;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        // unset the owning side of the relation if necessary
        if ($client === null && $this->client !== null) {
            $this->client->setIdUser(null);
        }

        // set the owning side of the relation if necessary
        if ($client !== null && $client->getIdUser() !== $this) {
            $client->setIdUser($this);
        }

        $this->client = $client;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): static
    {
        // unset the owning side of the relation if necessary
        if ($admin === null && $this->admin !== null) {
            $this->admin->setIdUser(null);
        }

        // set the owning side of the relation if necessary
        if ($admin !== null && $admin->getIdUser() !== $this) {
            $admin->setIdUser($this);
        }

        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setIdUser($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getIdUser() === $this) {
                $avi->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setIdUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getIdUser() === $this) {
                $commande->setIdUser(null);
            }
        }

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
            $this->lien->setIdUser(null);
        }

        // set the owning side of the relation if necessary
        if ($lien !== null && $lien->getIdUser() !== $this) {
            $lien->setIdUser($this);
        }

        $this->lien = $lien;

        return $this;
    }

    public function getUtilisateurUser(): ?User
    {
        return $this->utilisateurUser;
    }

    public function setUtilisateurUser(?User $utilisateurUser): static
    {
        // unset the owning side of the relation if necessary
        if ($utilisateurUser === null && $this->utilisateurUser !== null) {
            $this->utilisateurUser->setUtilisateur(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateurUser !== null && $utilisateurUser->getUtilisateur() !== $this) {
            $utilisateurUser->setUtilisateur($this);
        }

        $this->utilisateurUser = $utilisateurUser;

        return $this;
    }
}
