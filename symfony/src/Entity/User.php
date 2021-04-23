<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=0, nullable=false)
     * @Assert\Choice({"contact", "agent", "target"})
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=true)
     * @Assert\NotNull()
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=true)
     * @Assert\NotNull()
     */
    private $prenom;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="born", type="datetime", nullable=true)
     * @Assert\NotNull()
     */
    private $born;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=20, nullable=true)
     * @Assert\NotNull()
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nationality", type="string", length=45, nullable=true)
     * @Assert\Country()
     * @Assert\NotNull()
     */
    private $nationality;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Mission", mappedBy="affected", cascade={"persist"})
     */
    private $mission;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Speciality", inversedBy="agent", cascade={"persist"})
     * @ORM\JoinTable(name="specialized_in",
     *   joinColumns={
     *     @ORM\JoinColumn(name="agent_id", referencedColumnName="id_user")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="in_speciality_id", referencedColumnName="id_spec")
     *   }
     * )
     * @Assert\Count(min=1)
     */
    private $inSpeciality;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mission = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inSpeciality = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBorn(): ?\DateTimeInterface
    {
        return $this->born;
    }

    public function setBorn(?\DateTimeInterface $born): self
    {
        $this->born = $born;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->mission->contains($mission)) {
            $this->mission[] = $mission;
            $mission->addAffected($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            $mission->removeAffected($this);
        }

        return $this;
    }

    /**
     * @return Collection|Speciality[]
     */
    public function getInSpeciality(): Collection
    {
        return $this->inSpeciality;
    }

    public function addInSpeciality(Speciality $inSpeciality): self
    {
        if (!$this->inSpeciality->contains($inSpeciality)) {
            $this->inSpeciality[] = $inSpeciality;
        }

        return $this;
    }

    public function removeInSpeciality(Speciality $inSpeciality): self
    {
        $this->inSpeciality->removeElement($inSpeciality);

        return $this;
    }

    public function __toString()
    {
        return $this->nom.' '.$this->prenom;
    }
}
