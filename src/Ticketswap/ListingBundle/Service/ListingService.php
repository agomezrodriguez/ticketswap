<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 14/08/16
 * Time: 13:19
 */

namespace Ticketswap\ListingBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Ticketswap\BarcodeBundle\Entity\Barcodes;
use Ticketswap\ListingBundle\Entity\Listings;
use Ticketswap\ListingBundle\Validation\PostListing;
use Ticketswap\TicketBundle\Entity\Tickets;

class ListingService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param PostListing $listingPost
     * @throws \Exception
     */
    public function createListing(PostListing $listingPost)
    {
        $this->processBusinessRules($listingPost);
        $data = $this->prepareData($listingPost);

        $this->em->getRepository('TicketswapListingBundle:Listings');
        $this->em->persist($data['listing']);
        $this->em->flush();

        $ticket = $data['ticket'];
        for ($i=0;$i<$data['amountOfTickets'];$i++) {
            $this->em->getRepository('TicketswapTicketBundle:Tickets');
            //Doctrine needs a new object to persist on each iteration
            $ticket = clone $ticket;
            $this->em->persist($ticket);
            $this->em->flush();

            $barcode = $data['barcodes'][$i];
            $barcode->setTicket($ticket);
            $this->em->getRepository('TicketswapBarcodeBundle:Barcodes');
            $this->em->persist($barcode);
            $this->em->flush();
        }
    }

    /**
     * @param PostListing $listingPost
     * @return mixed
     * @throws \Exception
     */
    private function prepareData(PostListing $listingPost) {
        $uid = $listingPost->getListing()['uid'];
        $user = $this->em->getRepository('TicketswapUserBundle:Users')->find($uid);

        if (is_null($user)) {
            throw new \Exception('User ' . $uid . ' not found');
        }
        //TODO check number of tickets == number of barcodes

        $data['listing'] = new Listings();
        $data['listing']
            ->setUser($user)
            ->setDescription($listingPost->getListing()['description'])
            ->setSellingPrice($listingPost->getListing()['sellingPrice']);
        
        $providedBarcodes = $listingPost->getListing('tickets')['tickets']->tickets;
        $data['amountOfTickets'] = count($providedBarcodes);

        $data['ticket'] = new Tickets();
        $data['ticket']
            ->setBoughtAtDate(null)
            ->setBoughtByUserId(null)
            ->setListing($data['listing']);

        for ($i=0;$i<$data['amountOfTickets'];$i++) {
            $barcode = new Barcodes();
            $barcode
                ->setBarcode($providedBarcodes[$i])
                ->setTicket($data['ticket']);
            $barcodes[] = $barcode;
        }
        $data['barcodes'] = $barcodes;
        return $data;
    }

    private function processBusinessRules(PostListing $listingPost)
    {
        $barcodes = $listingPost->getListing()['tickets']->tickets;
        $uid = $listingPost->getListing()['uid'];
        
        $this->detectListingDuplicateBarcodes($barcodes);
        $this->detectBarcodeBelongsToLastBuyer($barcodes, $uid);
        $this->detectSellerDuplicateListing($barcodes);
    }

    /**
     * @param $barcodes
     * @throws \Exception
     */
    private function detectListingDuplicateBarcodes($barcodes)
    {
        if (array_unique($barcodes) !== $barcodes) {
            throw new \Exception('Tickets contains duplicate barcodes');
        }
    }

    /**
     * @param $barcodes
     * @param $requesterUid
     * @throws \Exception
     */
    private function detectBarcodeBelongsToLastBuyer($barcodes, $requesterUid)
    {
        foreach ($barcodes as $barcode) {
            $sql = "      
              SELECT t.boughtByUserId as uid
              FROM Ticketswap\BarcodeBundle\Entity\Barcodes b
              INNER JOIN b.ticket t
              WHERE b.barcode = :barcode AND t.boughtByUserId IS NOT NULL
              GROUP BY t.boughtByUserId, t.boughtAtDate
              ORDER BY t.boughtAtDate DESC
            ";
            $uids = $this->em
                ->createQuery($sql)
                ->setParameter(':barcode', $barcode)
                ->getResult(Query::HYDRATE_OBJECT)
            ;
            if (count($uids) > 0) {
                $uid = $uids[0]['uid'];
                if ($uid != $requesterUid) {
                    throw new \Exception('Barcode ' . $barcode . ' belongs to another user');
                }
            }
        }
    }

    /**
     * @param $barcodes
     * @throws \Exception
     */
    public function detectSellerDuplicateListing($barcodes)
    {
        foreach ($barcodes as $barcode) {
            //determine whether seller is trying to publish duplicate barcode tickets
            $sql = "      
                      SELECT t.id
                      FROM Ticketswap\TicketBundle\Entity\Tickets t
                      WHERE t.listing IN(
                        SELECT l.id
                        FROM Ticketswap\BarcodeBundle\Entity\Barcodes b
                        INNER JOIN b.ticket ti
                        INNER JOIN ti.listing l
                        WHERE b.barcode = :barcode
                    ) AND t.boughtByUserId IS NULL
                    ";
            $ticketId = $this->em
                ->createQuery($sql)
                ->setParameter(':barcode', $barcode)
                ->getResult(Query::HYDRATE_OBJECT);
            if (count($ticketId) > 0) {
                throw new \Exception('You have another listing published with barcode ' . $barcode);
            }
        }
    }

    /**
     * @param $uid
     * @return array
     */
    public function getListingsOfAUser($uid)
    {
        $user = $this->em->getRepository('TicketswapUserBundle:Users')->find($uid);
        return $this->em->getRepository('TicketswapListingBundle:Listings')->findBy(['user' => $user]);
    }
}
