<?php

namespace Ticketswap\BarcodeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ticketswap\BarcodeBundle\Entity\Barcodes;
use Ticketswap\BarcodeBundle\Form\BarcodesType;

/**
 * Barcodes controller.
 *
 */
class BarcodesController extends Controller
{
    /**
     * Lists all Barcodes entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $barcodes = $em->getRepository('TicketswapBarcodeBundle:Barcodes')->findAll();

        return $this->render('barcodes/index.html.twig', array(
            'barcodes' => $barcodes,
        ));
    }

    /**
     * Creates a new Barcodes entity.
     *
     */
    public function newAction(Request $request)
    {
        $barcode = new Barcodes();
        $form = $this->createForm('Ticketswap\BarcodeBundle\Form\BarcodesType', $barcode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($barcode);
            $em->flush();

            return $this->redirectToRoute('barcode_show', array('id' => $barcode->getId()));
        }

        return $this->render('barcodes/new.html.twig', array(
            'barcode' => $barcode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Barcodes entity.
     *
     */
    public function showAction(Barcodes $barcode)
    {
        $deleteForm = $this->createDeleteForm($barcode);

        return $this->render('barcodes/show.html.twig', array(
            'barcode' => $barcode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Barcodes entity.
     *
     */
    public function editAction(Request $request, Barcodes $barcode)
    {
        $deleteForm = $this->createDeleteForm($barcode);
        $editForm = $this->createForm('Ticketswap\BarcodeBundle\Form\BarcodesType', $barcode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($barcode);
            $em->flush();

            return $this->redirectToRoute('barcode_edit', array('id' => $barcode->getId()));
        }

        return $this->render('barcodes/edit.html.twig', array(
            'barcode' => $barcode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Barcodes entity.
     *
     */
    public function deleteAction(Request $request, Barcodes $barcode)
    {
        $form = $this->createDeleteForm($barcode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($barcode);
            $em->flush();
        }

        return $this->redirectToRoute('barcode_index');
    }

    /**
     * Creates a form to delete a Barcodes entity.
     *
     * @param Barcodes $barcode The Barcodes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Barcodes $barcode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('barcode_delete', array('id' => $barcode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
