<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $media;
    /**
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @ORM\ManyToMany(targetEntity=Techno::class, inversedBy="id_projet")
     */
    private $id_techno;

    public function __construct()
    {
        $this->id_techno = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getmedia()
    {
        return $this->media;
    }

    public function setmedia($media)
    {
        $this->media = $media;

        return $this;
    }
    public function geturl()
    {
        return $this->url;
    }

    public function seturl($url)
    {
        $this->url = $url;

        return $this;
    }


    /**
     * @return Collection|Techno[]
     */
    public function getIdTechno(): Collection
    {
        return $this->id_techno;
    }

    public function addIdTechno(Techno $idTechno): self
    {
        if (!$this->id_techno->contains($idTechno)) {
            $this->id_techno[] = $idTechno;
        }

        return $this;
    }

    public function removeIdTechno(Techno $idTechno): self
    {
        $this->id_techno->removeElement($idTechno);

        return $this;
    }
}
