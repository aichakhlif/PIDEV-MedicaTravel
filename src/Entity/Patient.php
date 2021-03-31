<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *@Assert\NotBlank(message="Cin is required")
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255)
     * *@Assert\NotBlank(message="Nom is required")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Prenom is required")
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(message="Age is required")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="age is required")
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Nom is required")
     */
    private $pays;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(
     * min="8",
     * max="8",
     * minMessage="veuillez remplir de nouveau votre numéro de téléphone",
     * maxMessage="veuillez remplir de nouveau votre numéro de téléphone",
     * allowEmptyString="false ")
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="patient")

     */
    private $Reclamation;

    public function __construct()
    {
        $this->Reclamation = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamation(): Collection
    {
        return $this->Reclamation;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->Reclamation->contains($reclamation)) {
            $this->Reclamation[] = $reclamation;
            $reclamation->setPatient($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->Reclamation->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getPatient() === $this) {
                $reclamation->setPatient(null);
            }
        }

        return $this;
    }

    public function __toString():String
    {
        return $this->nom;
    }


}
