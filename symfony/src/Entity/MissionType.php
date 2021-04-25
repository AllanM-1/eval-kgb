<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MissionType
 *
 * @ORM\Table(name="mission_type")
 * @ORM\Entity(repositoryClass="App\Repository\MissionTypeRepository")
 */
class MissionType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_mission_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMissionType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=true)
     * @Assert\NotNull()
     */
    private $name;

    public function getIdMissionType(): ?int
    {
        return $this->idMissionType;
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

    public function __toString()
    {
        return $this->name;
    }
}
