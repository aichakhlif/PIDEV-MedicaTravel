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
 * @UniqueEntity("email")
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
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
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
     * @ORM\ManyToMany(targetEntity=Specialite::class, inversedBy="Medecins")
     */
    private $Specialite;



    public function __construct()
    {
        $this->Specialite = new ArrayCollection();
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


}
