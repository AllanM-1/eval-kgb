<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HideoutType
 *
 * @ORM\Table(name="hideout_type")
 * @ORM\Entity(repositoryClass="App\Repository\HideoutTypeRepository")
 */
class HideoutType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_hideout_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idHideoutType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=60, nullable=true)
     */
    private $name;

    public function getIdHideoutType(): ?int
    {
        return $this->idHideoutType;
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
        return (string) $this->name;
    }
}
