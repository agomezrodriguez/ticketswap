<?php

namespace Ticketswap\ListingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ticketswap\UserBundle\Entity\Users;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Listings
 *
 * @ORM\Entity
 */
class Listings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     * @ORM\OneToMany(targetEntity="Ticketswap\TicketBundle\Entity\Tickets", mappedBy="listing")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="selling_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $sellingPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     */
    private $description = '';

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Ticketswap\UserBundle\Entity\Users", inversedBy="listings")
     * @JoinColumn(name="uid", referencedColumnName="id")
     */
    private $user;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * @param string $sellingPrice
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->sellingPrice = $sellingPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Users $user
     */
    public function setUser(Users $user)
    {
        $this->user = $user;
        return $this;
    }

    

}

