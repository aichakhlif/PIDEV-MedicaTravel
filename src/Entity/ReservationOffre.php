<?php

namespace App\Entity;

use App\Repository\ReservationOffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use  Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationOffreRepository::class)
 */
class ReservationOffre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *      *      * @Assert\NotBlank(message="Ce champs est obligatoire")
     * * @Assert\Length(min=3,max=30)


     */
    private $nom;


    /**
     * @ORM\Column(type="string", length=255)
     *      *      * @Assert\NotBlank(message="Ce champs est obligatoire")
     * * @Assert\Length(min=3,max=30)


     */
    private $email;


    /**
     * @ORM\Column(type="string", length=255)
     *      *      * @Assert\NotBlank(message="Ce champs est obligatoire")
     * * @Assert\Length(min=3,max=30)

     */
    private $pays;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="reservationoffres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;


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

    public function getOffre(): ?offre
    {
        return $this->offre;
    }

    public function setOffre(?offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }




}
