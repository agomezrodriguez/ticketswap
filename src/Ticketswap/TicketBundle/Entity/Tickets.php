<?php

namespace Ticketswap\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tickets
 *
 * @ORM\Table(name="tickets", indexes={@ORM\Index(name="fk_listing_id", columns={"listing_id"})})
 * @ORM\Entity
 */
class Tickets
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
     * @var integer
     *
     * @ORM\Column(name="bought_by_user_id", type="integer", nullable=true)
     */
    private $boughtByUserId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bought_at_date", type="datetime", nullable=true)
     */
    private $boughtAtDate;

    /**
     * @var \Listings
     *
     * @ORM\ManyToOne(targetEntity="Ticketswap\ListingBundle\Entity\Listings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="listing_id", referencedColumnName="id")
     * })
     */
    private $listing;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return int
     */
    public function getBoughtByUserId()
    {
        return $this->boughtByUserId;
    }

    /**
     * @param int $boughtByUserId
     */
    public function setBoughtByUserId($boughtByUserId)
    {
        $this->boughtByUserId = $boughtByUserId;
    }

    /**
     * @return \DateTime
     */
    public function getBoughtAtDate()
    {
        return $this->boughtAtDate;
    }

    /**
     * @param \DateTime $boughtAtDate
     */
    public function setBoughtAtDate($boughtAtDate)
    {
        $this->boughtAtDate = $boughtAtDate;
    }

    /**
     * @return \Listings
     */
    public function getListing()
    {
        return $this->listing;
    }

    /**
     * @param \Listings $listing
     */
    public function setListing($listing)
    {
        $this->listing = $listing;
    }


}

