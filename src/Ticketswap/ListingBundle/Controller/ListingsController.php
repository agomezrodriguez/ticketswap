<?php

namespace Ticketswap\ListingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ticketswap\ListingBundle\Entity\Listings;
use Ticketswap\ListingBundle\Form\ListingsType;

/**
 * Listings controller.
 *
 */
class ListingsController extends Controller
{
    /**
     * Lists all Listings entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listings = $em->getRepository('TicketswapListingBundle:Listings')->findAll();

        return $this->render('listings/index.html.twig', array(
            'listings' => $listings,
        ));
    }

    /**
     * Creates a new Listings entity.
     *
     */
    public function newAction(Request $request)
    {
        $listing = new Listings();
        $form = $this->createForm('Ticketswap\ListingBundle\Form\ListingsType', $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($listing);
            $em->flush();

            return $this->redirectToRoute('listing_show', array('id' => $listing->getId()));
        }

        return $this->render('listings/new.html.twig', array(
            'listing' => $listing,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Listings entity.
     *
     */
    public function showAction(Listings $listing)
    {
        $deleteForm = $this->createDeleteForm($listing);

        return $this->render('listings/show.html.twig', array(
            'listing' => $listing,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Listings entity.
     *
     */
    public function editAction(Request $request, Listings $listing)
    {
        $deleteForm = $this->createDeleteForm($listing);
        $editForm = $this->createForm('Ticketswap\ListingBundle\Form\ListingsType', $listing);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($listing);
            $em->flush();

            return $this->redirectToRoute('listing_edit', array('id' => $listing->getId()));
        }

        return $this->render('listings/edit.html.twig', array(
            'listing' => $listing,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Listings entity.
     *
     */
    public function deleteAction(Request $request, Listings $listing)
    {
        $form = $this->createDeleteForm($listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($listing);
            $em->flush();
        }

        return $this->redirectToRoute('listing_index');
    }

    /**
     * Creates a form to delete a Listings entity.
     *
     * @param Listings $listing The Listings entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Listings $listing)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('listing_delete', array('id' => $listing->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
