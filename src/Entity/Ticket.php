<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class Ticket.
 * @author Ingeniero en computación: Ricardo Presilla.
 * @version 1.0.
 */
class Ticket
{
    /**
     * @var integer
     *
     * @Assert\Range(
     *     min =1,
     *     max=10000,
     *      minMessage = "El número del ticket debe ser mínimo {{ limit }}. ",
     *      maxMessage = "El número del ticket no debe ser mayor a {{ limit }}. ")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min =2,
     *     max=255,
     *      minMessage = "El nombre debe ser mínimo {{ limit }} caracteres de largo",
     *      maxMessage = "El nombre no debe tener mas de {{ limit }} caracteres")
     */
    private $nombre;

    /**
     * Ticket constructor.
     */
    public function __construct()
    {
        $this->id = 0;
        $this->nombre = "";
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

}