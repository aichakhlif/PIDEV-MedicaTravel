<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 *  @UniqueEntity("email")

 */
class Medecin
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
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50,unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *@Assert\Length(
     * min="8",
     * max="8",
     * minMessage="veuillez remplir de nouveau votre numéro de téléphone",
     * maxMessage="veuillez remplir de nouveau votre numéro de téléphone",
     * allowEmptyString="false ")
     */
    private $num;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pic;



    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="medecin")
     * * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="medecin")

     */
    private $reclamations;
    private $reservations;

    /**
     * @ORM\ManyToMany(targetEntity=Specialite::class, inversedBy="Medecins")
     */
    private $Specialite;

    /**
     * @ORM\ManyToOne(targetEntity=Clinique::class, inversedBy="medecin")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clinique;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="Medecin", orphanRemoval=true)
     */
    private $rendezVouses;



    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->Specialite = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();


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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }


    public function __toString():String
    {
        return $this->getNom()." ".$this->getPrenom() ;
    }

    public function getPic()
    {
        return $this->pic;
    }

    public function setPic( $pic)
    {
        $this->pic = $pic;

        return $this;
    }



    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setMedecin($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getMedecin() === $this) {
                $reclamation->setMedecin(null);
            }
        }

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
            $reservation->setMedecin($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getMedecin() === $this) {
                $reservation->setMedecin(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Offre[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setMedecin($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getMedecin() === $this) {
                $offre->setMedecin(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Specialite[]
     */
    public function getSpecialite(): Collection
    {
        return $this->Specialite;
    }

    public function addSpecialite(Specialite $Specialite): self
    {
        if (!$this->Specialite->contains($Specialite)) {
            $this->Specialite[] = $Specialite;
        }

        return $this;
    }

    public function removeSpecialite(Specialite $Specialite): self
    {
        $this->Specialite->removeElement($Specialite);

        return $this;
    }

    public function getClinique(): ?Clinique
    {
        return $this->clinique;
    }

    public function setClinique(?Clinique $clinique): self
    {
        $this->clinique = $clinique;

        return $this;
    }

/* public function __toString():String
    {
        return $this->nom;
    }*/


    /**
     * @return Collection|RendezVous[]
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses[] = $rendezVouse;
            $rendezVouse->setMedecin($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getMedecin() === $this) {
                $rendezVouse->setMedecin(null);
            }
        }

        return $this;
    }




}
