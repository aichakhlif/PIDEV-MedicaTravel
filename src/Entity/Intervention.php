<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=InterventionRepository::class)
 */
class Intervention
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;


    /**
     * @ORM\OneToOne(targetEntity=Specialite::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Specialite;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $Description): self
    {
        $this->description = $Description;

        return $this;
    }


    public function getSpecialite(): ?Specialite
    {
        return $this->Specialite;
    }

    public function setSpecialite(Specialite $Specialite): self
    {
        $this->Specialite = $Specialite;

        return $this;
    }







}
