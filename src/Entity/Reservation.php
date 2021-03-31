<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use  Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     * * @Assert\Length(min=3,max=30)


     */
    private $nom;


    /**
     * @ORM\Column(type="string", length=255)
     *      * @Assert\NotBlank(message="Ce champs est obligatoire")
     *      * * @Assert\Email()



     */
    private $email;


    /**
     * @ORM\Column(type="string", length=255)
     *      * @Assert\NotBlank(message="Ce champs est obligatoire")
     * * @Assert\Length(min=3,max=30)


     */
    private $pays;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * * @Assert\Length(min=3,max=30)


     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=Intervention::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)

     */
    private $intervention;

    /**
     * @ORM\ManyToOne(targetEntity=Clinique::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)

     */
    private $clinique;


    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
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


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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

    public function getClinique(): ?clinique
    {
        return $this->clinique;
    }

    public function setClinique(?clinique $clinique): self
    {
        $this->clinique = $clinique;

        return $this;
    }



}
