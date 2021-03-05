<?php

namespace App\Entity;

use App\Repository\CliniqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CliniqueRepository::class)
 */
class Clinique
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
    private $nomclinique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseclinique;

    /**
     * @ORM\Column(type="integer")
     */
    private $numtel;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="clinique", orphanRemoval=true)
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomclinique(): ?string
    {
        return $this->nomclinique;
    }

    public function setNomclinique(string $nomclinique): self
    {
        $this->nomclinique = $nomclinique;

        return $this;
    }

    public function getAdresseclinique(): ?string
    {
        return $this->adresseclinique;
    }

    public function setAdresseclinique(string $adresseclinique): self
    {
        $this->adresseclinique = $adresseclinique;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setClinique($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getClinique() === $this) {
                $reservation->setClinique(null);
            }
        }

        return $this;
    }

    //convertir un objet en string
    function __toString()
    {
        return(string)$this->getNomclinique();

    }
}
