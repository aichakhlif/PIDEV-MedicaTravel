<?php

namespace App\Entity;

use App\Repository\OffreRepository;
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
     *  @Assert\NotBlank()
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
     * @Assert\NotBlank()
     */
    private $prix;

    /**
     * @ORM\Column(type="date")
     */
    private $date;



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


}
