<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hideouts
 *
 * @ORM\Table(name="hideouts")
 * @ORM\Entity
 */
class Hideouts
{
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
     * @var int|null
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \HideoutsType
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="HideoutsType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Missions", mappedBy="hideout")
     */
    private $mission;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mission = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getId(): ?HideoutsType
    {
        return $this->id;
    }

    public function setId(?HideoutsType $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection|Missions[]
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(Missions $mission): self
    {
        if (!$this->mission->contains($mission)) {
            $this->mission[] = $mission;
            $mission->addHideout($this);
        }

        return $this;
    }

    public function removeMission(Missions $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            $mission->removeHideout($this);
        }

        return $this;
    }

}
