<?php

namespace App\Entity;

use App\Repository\ColaAtencion1Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColaAtencion1Repository::class)
 */
class ColaAtencion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idTicket;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTicket(): ?int
    {
        return $this->idTicket;
    }

    public function setIdTicket(int $idTicket): self
    {
        $this->idTicket = $idTicket;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}
