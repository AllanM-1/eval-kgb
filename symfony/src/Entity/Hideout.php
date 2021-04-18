<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hideout
 *
 * @ORM\Table(name="hideout", indexes={@ORM\Index(name="hideouts_type_idx", columns={"type"})})
 * @ORM\Entity(repositoryClass="App\Repository\HideoutRepository")
 */
class Hideout
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_hideout", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idHideout;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=20, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=60, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postcode", type="string", length=16, nullable=true)
     */
    private $postcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=60, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $country;

    /**
     * @var \HideoutType
     *
     * @ORM\ManyToOne(targetEntity="HideoutType", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id_hideout_type")
     * })
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Mission", mappedBy="idHideout", cascade={"persist"})
     */
    private $idMission;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idMission = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdHideout(): ?int
    {
        return $this->idHideout;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getType(): ?HideoutType
    {
        return $this->type;
    }

    public function setType(?HideoutType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getIdMission(): Collection
    {
        return $this->idMission;
    }

    public function addIdMission(Mission $idMission): self
    {
        if (!$this->idMission->contains($idMission)) {
            $this->idMission[] = $idMission;
            $idMission->addIdHideout($this);
        }

        return $this;
    }

    public function removeIdMission(Mission $idMission): self
    {
        if ($this->idMission->removeElement($idMission)) {
            $idMission->removeIdHideout($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->address.' '.$this->postcode.' '.$this->city;
    }
}
