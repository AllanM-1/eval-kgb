<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Speciality
 *
 * @ORM\Table(name="speciality")
 * @ORM\Entity
 */
class Speciality
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
     * @ORM\Column(name="name", type="string", length=60, nullable=true)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="inSpeciality")
     */
    private $agent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(Users $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent[] = $agent;
            $agent->addInSpeciality($this);
        }

        return $this;
    }

    public function removeAgent(Users $agent): self
    {
        if ($this->agent->removeElement($agent)) {
            $agent->removeInSpeciality($this);
        }

        return $this;
    }

}
