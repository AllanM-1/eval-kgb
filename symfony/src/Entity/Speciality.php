<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Speciality
 *
 * @ORM\Table(name="speciality")
 * @ORM\Entity(repositoryClass="App\Repository\SpecialityRepository")
 */
class Speciality
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_spec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSpec;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=true)
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="inSpeciality")
     */
    private $agent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->agent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdSpec(): ?int
    {
        return $this->idSpec;
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
     * @return Collection|User[]
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(User $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent[] = $agent;
            $agent->addInSpeciality($this);
        }

        return $this;
    }

    public function removeAgent(User $agent): self
    {
        if ($this->agent->removeElement($agent)) {
            $agent->removeInSpeciality($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
