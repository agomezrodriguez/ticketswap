<?php

namespace Ticketswap\BarcodeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;


/**
 * Barcodes
 *
 * @ORM\Table(name="barcodes", indexes={@ORM\Index(name="fk_ticket_id", columns={"ticket_id"})})
 * @ORM\Entity
 */
class Barcodes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=50, nullable=false)
     */
    private $barcode = '';

    /**
     * @var \Tickets
     *
     * @ORM\ManyToOne(targetEntity="Ticketswap\TicketBundle\Entity\Tickets", inversedBy="barcodes")
     * @JoinColumn(name="ticket_id", referencedColumnName="id")
     * })
     */
    private $ticket;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return \Tickets
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param \Tickets $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }
}

