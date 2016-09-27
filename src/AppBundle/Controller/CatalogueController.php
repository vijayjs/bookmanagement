<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use AppBundle\Entity\Catalogue;
use AppBundle\Form\CatalogueType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/home", defaults={"page": 1}, name="catalogue_dashboard")
     * @Route("/home/{page}", requirements={"page": "[1-9]\d*"}, name="catalogue_dashboard_paginated")
     * @Method("GET")
     * @Cache(smaxage="10")
     */
    public function dashboardAction($page)
    {
		$request = Request::createFromGlobals();
		$search_term = $request->query->get('search_term');
        $em = $this->getDoctrine()->getManager();

        $catalogues = $em->getRepository('AppBundle:Catalogue')->findLatest($page, $search_term);

        return $this->render('catalogue/home.html.twig', array(
            'catalogues' => $catalogues, 'search_term'=>$search_term
        ));
    }

    /**
     * Lists all Catalogue entities.
     *
     * @Route("/user/{user}", defaults={"page": 1, "user":"[^/]++"}, name="catalogue_user")
     * @Route("/user/{user}/{page}", requirements={"page": "[1-9]\d*", "user":"[1-9]\d*"}, name="catalogue_user_paginated")
     * @Method("GET")
     * @Cache(smaxage="10")
     */
    public function userListAction($page, $user)
    {
        $em = $this->getDoctrine()->getManager();

        $catalogues = $em->getRepository('AppBundle:Catalogue')->findLatestByUser($page, $user);

        return $this->render('catalogue/user.html.twig', array(
            'catalogues' => $catalogues
        ));
    }

    /**
     * Lists all Catalogue entities.
     *
     * @Route("/", name="catalogue_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
		$user_id = $this->getUser()->getId();

        $catalogues = $em->getRepository('AppBundle:Catalogue')->findBy(array('user'=>$user_id));

        return $this->render('catalogue/index.html.twig', array(
            'catalogues' => $catalogues,
        ));
    }

    /**
     * search Catalogue entities.
     *
     * @Route("/search", name="catalogue_search")
     * @Method("GET")
     */

	 public function search(){
		$request = Request::createFromGlobals();
		$bookisbn = $request->query->get('bookisbn');
		echo $book_data = file_get_contents('https://openlibrary.org/api/books?bibkeys=ISBN:'.$bookisbn.',&format=json&jscmd=data');
		exit;
		//return new JsonResponse($book_data);
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
			$catalogue->setUser($this->getUser());
			
			$attachmentThumb = $form['attachmentThumb']->getData();
			if(!empty($attachmentThumb)){
				$NewFilename = rand().'.jpg';
				$dataataach = $form['attachmentThumb']->getData()->move('web/uploads', $NewFilename);
				$catalogue->setattachmentThumb($dataataach->getpathName());
			}
			$attachmentFile = $form['attachmentFile']->getData();
			if(!empty($attachmentFile)){
				$NewFilename1 = rand().'test.pdf';
				$data = $form['attachmentFile']->getData()->move('web/uploads', $NewFilename1);
				$catalogue->setattachmentFile($data->getpathName());
			}
			$attachmentThumb1 = $request->request->get('attachmentThumb1');
			if(!empty($attachmentThumb1)){
				$catalogue->setattachmentThumb($attachmentThumb1);
			}
			$attachmentFile1 = $request->request->get('attachmentFile1');
			if(!empty($attachmentFile1)){
				$catalogue->setattachmentFile($attachmentFile1);
			}
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
