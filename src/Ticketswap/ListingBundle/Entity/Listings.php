<?php

namespace Ticketswap\ListingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Listings
 *
 * @ORM\Table(name="listings", indexes={@ORM\Index(name="uid", columns={"uid"})})
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
     * @ORM\ManyToOne(targetEntity="Ticketswap\UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="uid", referencedColumnName="id")
     * })
     */
    private $uid;

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
    }

    /**
     * @return \Users
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param \Users $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    

}

