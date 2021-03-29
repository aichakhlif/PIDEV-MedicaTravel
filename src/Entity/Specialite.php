<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SpecialiteRepository::class)
 * @UniqueEntity("titre")

 */
class Specialite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     * @Assert\NotBlank()
     */
    private $titre;

    /**
     * @ORM\ManyToMany(targetEntity=Medecin::class, mappedBy="Specialite")
     */
    private $Medecins;

    public function __construct()
    {
        $this->Medecins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection|Medecin[]
     */
    public function getMedecins(): Collection
    {
        return $this->Medecins;
    }

    public function addMedecin(Medecin $Medecin): self
    {
        if (!$this->Medecins->contains($Medecin)) {
            $this->Medecins[] = $Medecin;
            $Medecin->addSpecialite($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $Medecin): self
    {
        if ($this->Medecins->removeElement($Medecin)) {
            $Medecin->removeSpecialite($this);
        }

        return $this;
    }

    public function __toString():string
    {
     return $this->getTitre(); }


}
