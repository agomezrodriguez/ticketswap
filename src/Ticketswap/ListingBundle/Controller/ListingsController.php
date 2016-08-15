<?php

namespace Ticketswap\ListingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ticketswap\BarcodeBundle\Entity\Barcodes;
use Ticketswap\CommonBundle\Util\Binder;
use Ticketswap\ListingBundle\Entity\Listings;
use FOS\RestBundle\Controller\Annotations as API;
use Ticketswap\ListingBundle\Validation\PostListing;
use Ticketswap\TicketBundle\Entity\Tickets;

/**
 * Listings controller.
 *
 */
class ListingsController extends Controller
{
    /**
     * Lists all Listings entities.
     * @API\Get("/listing/all")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TicketswapUserBundle:Users')->find(1);
        $listings = $em->getRepository('TicketswapListingBundle:Listings')->findBy(['user' => $user]);

        return $this->render('listings/index.html.twig', array(
            'listings' => $listings,
        ));
    }

    /**
     * Creates a new Listings entity.
     * @API\Get("/listing/")

     */
    public function newListingFormAction()
    {
        return $this->render('listings/new.html.twig');
    }

    /**
     * Creates a new Listings entity.
     * @API\Post("/listing/")

     */
    public function postListingAction(Request $request)
    {
        $parameters = $request->request->all();
        $parameters['tickets'] = json_decode($parameters['tickets']);

        /** @var PostListing $listingPost */
        $listingPost = $this->get("ticketswap_listing.listing_post");
        $listingPost = $listingPost->bindData($parameters);
        $validator = $this->get("validator");
        $errors = $validator->validate($listingPost);

        if (0 !== count($errors)) {
            return $this->render('listings/new.html.twig', array(
                'errors' => $errors,
            ));
        }
        $listingManager = $this->get("ticketswap_listing.listing_service");
        try {
            $listingManager->createListing($listingPost);
        }catch (\Exception $e) {
            $error[]['message'] = $e->getMessage();
            return $this->render('listings/new.html.twig', array(
                'errors' => $error,
            ));
        }
        $uid = $listingPost->getListing()['uid'];
        $listings = $listingManager->getListingsOfAUser($uid);

        return $this->render('listings/index.html.twig', array(
            'listings' => $listings,
        ));
    }

    /**
     * Finds and displays a Listings entity.
     *
     */
    public function showAction(Listings $listing)
    {
        return $this->render('listings/show.html.twig', array(
            'listing' => $listing,
        ));
    }
}
