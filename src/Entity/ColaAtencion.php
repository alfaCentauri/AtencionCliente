<?php

namespace App\Entity;

use App\Repository\ColaAtencionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColaAtencionRepository::class)
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

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $numeroCola;

    /**
     * ColaAtencion constructor.
     */
    public function __construct()
    {
        $this->id = 0;
        $this->idTicket = 0;
        $this->nombre = "";
        $this->numeroCola = 1;
    }

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

    /**
     * @return int
     */
    public function getNumeroCola(): int
    {
        return $this->numeroCola;
    }

    /**
     * @param int $numeroCola
     */
    public function setNumeroCola(int $numeroCola): void
    {
        $this->numeroCola = $numeroCola;
    }

}
