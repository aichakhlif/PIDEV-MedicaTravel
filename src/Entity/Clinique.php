<?php

namespace App\Entity;

use App\Repository\CliniqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @Assert\NotBlank()
     */
    private $adresse;

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
    private $tel;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="clinique", orphanRemoval=true)
     */
    private $offres;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Medecin::class, mappedBy="clinique", orphanRemoval=true)
     */
    private $medecin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $email;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
        $this->medecin = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

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
            $offre->setClinique($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getClinique() === $this) {
                $offre->setClinique(null);
            }
        }

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
    public function __toString()
    {
        return(string)$this->getNom();
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|medecin[]
     */
    public function getMedecin(): Collection
    {
        return $this->medecin;
    }

    public function addMedecin(medecin $medecin): self
    {
        if (!$this->medecin->contains($medecin)) {
            $this->medecin[] = $medecin;
            $medecin->setClinique($this);
        }

        return $this;
    }

    public function removeMedecin(medecin $medecin): self
    {
        if ($this->medecin->removeElement($medecin)) {
            // set the owning side to null (unless already changed)
            if ($medecin->getClinique() === $this) {
                $medecin->setClinique(null);
            }
        }

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

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


}
