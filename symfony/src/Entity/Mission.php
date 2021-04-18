<?php

namespace App\Entity;

use App\Validator\MinAgent;
use App\Validator\SameCountry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mission
 *
 * @ORM\Table(name="mission", indexes={@ORM\Index(name="mission_spec_idx", columns={"spec"}), @ORM\Index(name="type_idx", columns={"type"})})
 * @ORM\Entity(repositoryClass="App\Repository\MissionRepository")
 */
class Mission
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mission", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMission;

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
     * @ORM\ManyToOne(targetEntity="Speciality", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="spec", referencedColumnName="id_spec")
     * })
     */
    private $spec;

    /**
     * @var \MissionType
     *
     * @ORM\ManyToOne(targetEntity="MissionType", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type", referencedColumnName="id_mission_type")
     * })
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="mission", cascade={"persist"})
     * @ORM\JoinTable(name="affected_to",
     *   joinColumns={
     *     @ORM\JoinColumn(name="mission_id", referencedColumnName="id_mission")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="affected_id", referencedColumnName="id_user")
     *   }
     * )
     * @MinAgent()
     */
    private $affected;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Hideout", inversedBy="idMission", cascade={"persist"})
     * @ORM\JoinTable(name="hide_in",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_mission", referencedColumnName="id_mission")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_hideout", referencedColumnName="id_hideout")
     *   }
     * )
     * @SameCountry()
     */
    private $idHideout;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->affected = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idHideout = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdMission(): ?int
    {
        return $this->idMission;
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

    public function getType(): ?MissionType
    {
        return $this->type;
    }

    public function setType(?MissionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAffected(): Collection
    {
        return $this->affected;
    }

    public function addAffected(User $affected): self
    {
        if (!$this->affected->contains($affected)) {
            $this->affected[] = $affected;
        }

        return $this;
    }

    public function removeAffected(User $affected): self
    {
        $this->affected->removeElement($affected);

        return $this;
    }

    /**
     * @return Collection|Hideout[]
     */
    public function getIdHideout(): Collection
    {
        return $this->idHideout;
    }

    public function addIdHideout(Hideout $idHideout): self
    {
        if (!$this->idHideout->contains($idHideout)) {
            $this->idHideout[] = $idHideout;
        }

        return $this;
    }

    public function removeIdHideout(Hideout $idHideout): self
    {
        $this->idHideout->removeElement($idHideout);

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
