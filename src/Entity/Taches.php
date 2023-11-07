<?php

namespace App\Entity;

use App\Repository\TachesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TachesRepository::class)]
class Taches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 1024)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Statut $id_statut = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Projets $id_projet = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?User $id_user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIdStatut(): ?Statut
    {
        return $this->id_statut;
    }

    public function setIdStatut(?Statut $id_statut): static
    {
        $this->id_statut = $id_statut;

        return $this;
    }

    public function getIdProjet(): ?Projets
    {
        return $this->id_projet;
    }

    public function setIdProjet(?Projets $id_projet): static
    {
        $this->id_projet = $id_projet;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->id_user;
    }

    public function setIduser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }
}
