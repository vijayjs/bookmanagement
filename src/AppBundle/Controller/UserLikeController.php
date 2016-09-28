<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\UserLike;
use AppBundle\Form\UserLikeType;
use AppBundle\Entity\Catalogue;

/**
 * UserLike controller.
 *
 * @Route("/userlike")
 */
class UserLikeController extends Controller
{
    /**
     * Lists all UserLike entities.
     *
     * @Route("/", defaults={"page": 1}, name="userlike_index")
     * @Route("/{page}", requirements={"page": "[1-9]\d*"}, name="userlike_dashboard_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
		$user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $userLikes = $em->getRepository('AppBundle:UserLike')->findLatest($page, $user);

        return $this->render('userlike/index.html.twig', array(
            'catalogues' => $userLikes,
        ));
    }

    /**
     * Creates a new UserLike entity.
     *
     * @Route("/new", name="userlike_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userLike = new UserLike();
        $form = $this->createForm('AppBundle\Form\UserLikeType', $userLike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userLike);
            $em->flush();

            return $this->redirectToRoute('userlike_show', array('id' => $userLike->getId()));
        }

        return $this->render('userlike/new.html.twig', array(
            'userLike' => $userLike,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new UserLike entity.
     *
     * @Route("/new_like", name="userlike_new1")
     * @Method({"POST"})
     */
    public function newLikeAction(Request $request)
    {
		$catalogue = $request->request->get('catalogue_id'); 
		$em = $this->getDoctrine()->getManager();

        $catalogue = $em->getRepository('AppBundle:Catalogue')->findOneBy(array('id'=>$catalogue));
        $userLike = new UserLike();
        $userLike->setUser($this->getUser());
        $userLike->setCatelogue($catalogue);
		$em = $this->getDoctrine()->getManager();
		$em->persist($userLike);
		$em->flush();
		echo "success"; exit;
    }

    /**
     * Finds and displays a UserLike entity.
     *
     * @Route("/{id}", name="userlike_show")
     * @Method("GET")
     */
    public function showAction(UserLike $userLike)
    {
        $deleteForm = $this->createDeleteForm($userLike);

        return $this->render('userlike/show.html.twig', array(
            'userLike' => $userLike,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserLike entity.
     *
     * @Route("/{id}/edit", name="userlike_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserLike $userLike)
    {
        $deleteForm = $this->createDeleteForm($userLike);
        $editForm = $this->createForm('AppBundle\Form\UserLikeType', $userLike);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userLike);
            $em->flush();

            return $this->redirectToRoute('userlike_edit', array('id' => $userLike->getId()));
        }

        return $this->render('userlike/edit.html.twig', array(
            'userLike' => $userLike,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserLike entity.
     *
     * @Route("/{id}", name="userlike_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserLike $userLike)
    {
        $form = $this->createDeleteForm($userLike);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userLike);
            $em->flush();
        }

        return $this->redirectToRoute('userlike_index');
    }

    /**
     * Creates a form to delete a UserLike entity.
     *
     * @param UserLike $userLike The UserLike entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserLike $userLike)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userlike_delete', array('id' => $userLike->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
