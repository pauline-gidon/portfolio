<?php

namespace App\Entity;

use App\Repository\TechnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TechnoRepository::class)
 */
class Techno
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Projet::class, mappedBy="id_techno")
     */
    private $id_projet;

    public function __construct()
    {
        $this->id_projet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getIdProjet(): Collection
    {
        return $this->id_projet;
    }

    public function addIdProjet(Projet $idProjet): self
    {
        if (!$this->id_projet->contains($idProjet)) {
            $this->id_projet[] = $idProjet;
            $idProjet->addIdTechno($this);
        }

        return $this;
    }

    public function removeIdProjet(Projet $idProjet): self
    {
        if ($this->id_projet->removeElement($idProjet)) {
            $idProjet->removeIdTechno($this);
        }

        return $this;
    }
}
