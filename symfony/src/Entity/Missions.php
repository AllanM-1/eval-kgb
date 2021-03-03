<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Missions
 *
 * @ORM\Table(name="missions", indexes={@ORM\Index(name="mission_spec_idx", columns={"spec"}), @ORM\Index(name="type_idx", columns={"type"})})
 * @ORM\Entity
 */
class Missions
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=150, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=16777215, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=20, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=0, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * @var \Speciality
     *
     * @ORM\ManyToOne(targetEntity="Speciality")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="spec", referencedColumnName="id")
     * })
     */
    private $spec;

    /**
     * @var \MissionsType
     *
     * @ORM\ManyToOne(targetEntity="MissionsType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", inversedBy="mission")
     * @ORM\JoinTable(name="affected_to",
     *   joinColumns={
     *     @ORM\JoinColumn(name="mission_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="affected_id", referencedColumnName="id")
     *   }
     * )
     */
    private $affected;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Hideouts", inversedBy="mission")
     * @ORM\JoinTable(name="hide_in",
     *   joinColumns={
     *     @ORM\JoinColumn(name="mission_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="hideout_id", referencedColumnName="id")
     *   }
     * )
     */
    private $hideout;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->affected = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hideout = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getSpec(): ?Speciality
    {
        return $this->spec;
    }

    public function setSpec(?Speciality $spec): self
    {
        $this->spec = $spec;

        return $this;
    }

    public function getType(): ?MissionsType
    {
        return $this->type;
    }

    public function setType(?MissionsType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getAffected(): Collection
    {
        return $this->affected;
    }

    public function addAffected(Users $affected): self
    {
        if (!$this->affected->contains($affected)) {
            $this->affected[] = $affected;
        }

        return $this;
    }

    public function removeAffected(Users $affected): self
    {
        $this->affected->removeElement($affected);

        return $this;
    }

    /**
     * @return Collection|Hideouts[]
     */
    public function getHideout(): Collection
    {
        return $this->hideout;
    }

    public function addHideout(Hideouts $hideout): self
    {
        if (!$this->hideout->contains($hideout)) {
            $this->hideout[] = $hideout;
        }

        return $this;
    }

    public function removeHideout(Hideouts $hideout): self
    {
        $this->hideout->removeElement($hideout);

        return $this;
    }

}
