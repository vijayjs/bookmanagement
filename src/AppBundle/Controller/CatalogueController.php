<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Catalogue;
use AppBundle\Form\CatalogueType;

/**
 * Catalogue controller.
 *
 * @Route("/catalogue")
 */
class CatalogueController extends Controller
{
    /**
     * Lists all Catalogue entities.
     *
     * @Route("/", name="catalogue_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $catalogues = $em->getRepository('AppBundle:Catalogue')->findAll();

        return $this->render('catalogue/index.html.twig', array(
            'catalogues' => $catalogues,
        ));
    }

    /**
     * Creates a new Catalogue entity.
     *
     * @Route("/new", name="catalogue_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $catalogue = new Catalogue();
        $form = $this->createForm('AppBundle\Form\CatalogueType', $catalogue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($catalogue);
            $em->flush();

            return $this->redirectToRoute('catalogue_show', array('id' => $catalogue->getId()));
        }

        return $this->render('catalogue/new.html.twig', array(
            'catalogue' => $catalogue,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Catalogue entity.
     *
     * @Route("/{id}", name="catalogue_show")
     * @Method("GET")
     */
    public function showAction(Catalogue $catalogue)
    {
        $deleteForm = $this->createDeleteForm($catalogue);

        return $this->render('catalogue/show.html.twig', array(
            'catalogue' => $catalogue,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Catalogue entity.
     *
     * @Route("/{id}/edit", name="catalogue_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Catalogue $catalogue)
    {
        $deleteForm = $this->createDeleteForm($catalogue);
        $editForm = $this->createForm('AppBundle\Form\CatalogueType', $catalogue);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($catalogue);
            $em->flush();

            return $this->redirectToRoute('catalogue_edit', array('id' => $catalogue->getId()));
        }

        return $this->render('catalogue/edit.html.twig', array(
            'catalogue' => $catalogue,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Catalogue entity.
     *
     * @Route("/{id}", name="catalogue_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Catalogue $catalogue)
    {
        $form = $this->createDeleteForm($catalogue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($catalogue);
            $em->flush();
        }

        return $this->redirectToRoute('catalogue_index');
    }

    /**
     * Creates a form to delete a Catalogue entity.
     *
     * @param Catalogue $catalogue The Catalogue entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Catalogue $catalogue)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('catalogue_delete', array('id' => $catalogue->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
