<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Entity\Structure;
use CEOFESABundle\Form\Type\StructureType;
use Gedmo\Sluggable\Util\Urlizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Structure controller.
 *
 * @Route("/admin/structure")
 */
class StructureController extends Controller
{

    /**
     * Lists all Structure entities.
     *
     * @Route("/", name="structure")
     * @Method("GET")
     * @Template("::Structure\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CEOFESABundle:Structure')->getAllStructures()->getQuery()->getResult();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Structure entity.
     *
     * @Route("/", name="structure_create")
     * @Method("POST")
     * @Template("::Structure\new.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Structure();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('structure_show', array('id' => $entity->getStrId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Structure entity.
     *
     * @param Structure $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Structure $entity)
    {
        $form = $this->createForm(new StructureType(), $entity, array(
            'action' => $this->generateUrl('structure_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Structure entity.
     *
     * @Route("/new", name="structure_new")
     * @Method("GET")
     * @Template("::Structure\new.html.twig")
     */
    public function newAction()
    {
        $entity = new Structure();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Structure entity.
     *
     * @Route("/{id}", name="structure_show")
     * @Method("GET")
     * @Template("::Structure\show.html.twig")
     *
     * @param int $id
     *
     * @return array
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Structure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Structure entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Structure entity.
     *
     * @Route("/{id}/edit", name="structure_edit")
     * @Method("GET")
     * @Template("::Structure\edit.html.twig")
     *
     * @param int $id
     *
     * @return array
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Structure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Structure entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
    * Creates a form to edit a Structure entity.
    *
    * @param Structure $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Structure $entity)
    {
        $form = $this->createForm(new StructureType(), $entity, array(
            'action' => $this->generateUrl('structure_update', array('id' => $entity->getStrId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Structure entity.
     *
     * @Route("/{id}", name="structure_update")
     * @Method("PUT")
     * @Template("::Structure\edit.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int                                       $id
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Structure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Structure entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('structure_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Structure entity.
     *
     * @Route("/{id}", name="structure_delete")
     * @Method("DELETE")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int                                       $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CEOFESABundle:Structure')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Structure entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('structure'));
    }

    /**
     * Creates a form to delete a Structure entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('structure_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @Route(
     *     path         = "/convention_partenaire/{id}",
     *     name         = "convention_partenaire_pdf",
     *     requirements = { "id" = "\d+" }
     * )
     *
     * @param \CEOFESABundle\Entity\Structure $structure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printPartnerCovenantPdfAction(Structure $structure)
    {
        $html = $this->renderView('::Templates\convention_partenariat.html.twig', array('info' => $structure));

        $response= new Response();
        $response->setContent($this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
            'orientation' => 'Portrait',
            'page-size'   => 'A4',
        )));
        $response->headers->set('Content-Type', 'application/pdf');
        $filename = Urlizer::urlize(Urlizer::unaccent($structure->getStrNom()), '-');
        $response->headers->set(
            'Content-disposition',
            sprintf('filename=convention-partenariat-%s.pdf', $filename)
        );

        return $response;
    }
}
