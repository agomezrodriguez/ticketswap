<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 13/08/16
 * Time: 18:24
 */

namespace Ticketswap\ListingBundle\Validation;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Ticketswap\CommonBundle\Util\Binder;
use Ticketswap\CommonBundle\Validator\Validable;
use Symfony\Component\Validator\Constraints as Assert;
use Ticketswap\CommonBundle\Validator\Constraints as TicketswapAssert;

class PostListing
{
    /**
     * @Assert\Collection(
     *     fields={
     *          "uid" = {@Assert\Range(min=0, invalidMessage = "Invalid uid provided")},
     *          "sellingPrice" = {@Assert\Range(min=0, invalidMessage = "Invalid sellingPrice")},
     *          "description" = {@Assert\Length(max=200, maxMessage = "Too long description")},
     *          "tickets" = {@Assert\NotNull(message = "Invalid json tickets format provided"), @TicketswapAssert\Ticket()}
     *     },
     *     allowMissingFields = false
     * )
     */
    private $listing = [];
    private $validator;

    /**
     * @param array $parameters
     * @return $this
     */
    public function bindData(array $parameters)
    {
        Binder::bind($parameters, $this, true);
        return $this;
    }

    /**
     * @param $uid
     * @return $this
     */
    public function setUid($uid)
    {
        $this->listing['uid'] = $uid;
        return $this;
    }

    /**
     * @param $sellingPrice
     * @return $this
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->listing['sellingPrice'] = $sellingPrice;
        return $this;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->listing['description'] = $description;
        return $this;
    }

    /**
     * @param $tickets
     * @return $this
     */
    public function setTickets($tickets)
    {
        $this->listing['tickets'] = $tickets;
        return $this;
    }

    public function getListing()
    {
        return $this->listing;
    }

    /**
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator)
    {
        /** @var ValidatorInterface validator */
        $this->validator = $validator;
        return $this;
    }

}
