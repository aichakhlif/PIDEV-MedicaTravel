<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity=Clinique::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clinique;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     *  @Assert\NotBlank()

     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=Intervention::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     *  @Assert\NotBlank()
     */
    private $intervention;


    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

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


    public function getClinique(): ?clinique
    {
        return $this->clinique;
    }

    public function setClinique(?clinique $clinique): self
    {
        $this->clinique = $clinique;

        return $this;
    }

    public function getMedecin(): ?medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?medecin $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getIntervention(): ?intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?intervention $intervention): self
    {
        $this->intervention = $intervention;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
