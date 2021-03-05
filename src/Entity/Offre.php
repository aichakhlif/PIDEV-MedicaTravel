<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idmedecin;

    /**
     * @ORM\Column(type="integer")
     */
    private $idclinique;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=ReservationOffre::class, mappedBy="offre", orphanRemoval=true)
     */
    private $reservationoffres;

    public function __construct()
    {
        $this->reservationoffres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdmedecin(): ?int
    {
        return $this->idmedecin;
    }

    public function setIdmedecin(int $idmedecin): self
    {
        $this->idmedecin = $idmedecin;

        return $this;
    }

    public function getIdclinique(): ?int
    {
        return $this->idclinique;
    }

    public function setIdclinique(int $idclinique): self
    {
        $this->idclinique = $idclinique;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


    /**
     * @return Collection|Reservationoffre[]
     */
    public function getReservationoffres(): Collection
    {
        return $this->reservationoffres;
    }

    public function addReservationoffre(Reservationoffre $reservationoffre): self
    {
        if (!$this->reservationoffres->contains($reservationoffre)) {
            $this->reservationoffres[] = $reservationoffre;
            $reservationoffre->setOffre($this);
        }

        return $this;
    }

    public function removeReservationoffre(Reservationoffre $reservationoffre): self
    {
        if ($this->reservationoffres->removeElement($reservationoffre)) {
            // set the owning side to null (unless already changed)
            if ($reservationoffre->getOffre() === $this) {
                $reservationoffre->setOffre(null);
            }
        }

        return $this;
    }

    //convertir un objet en string
    function __toString()
    {
        return(string)$this->getId();
    }

}
