<?php

namespace CEOFESABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CEOFESABundle\Entity\Tiers;
use CEOFESABundle\Form\Type\StagiaireType;

/**
 * Tiers controller.
 *
 * @Route("/stagiaire")
 */
class StagiaireController extends Controller
{

    /**
     * Lists all Tiers entities.
     *
     * @Route("/liste", name="stagiaire_list")
     * @Method("GET")
     * @Template("::Stagiaire\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');
        $entities = $em->getRepository('CEOFESABundle:Tiers')->getStructureTiers($id)->getQuery()->getResult();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Tiers entity.
     *
     * @Route("/ajout", name="stagiaire_create")
     * @Method({"GET","POST"})
     * @Template("::Stagiaire\new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tiers();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('stagiaire_show', array('id' => $entity->getTrsId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Tiers entity.
     *
     * @param Tiers $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tiers $entity)
    {
        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new StagiaireType($id), $entity, array(
            'action' => $this->generateUrl('stagiaire_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Tiers entity.
     *
     * @Route("/new", name="stagiaire_new")
     * @Method("GET")
     * @Template("::Stagiaire\new.html.twig")
     */
    public function newAction()
    {
        $entity = new Tiers();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tiers entity.
     *
     * @Route("/{id}", name="stagiaire_show")
     * @Method("GET")
     * @Template("::Stagiaire\show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Tiers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tiers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tiers entity.
     *
     * @Route("/{id}/edit", name="stagiaire_edit")
     * @Method("GET")
     * @Template("::Stagiaire\edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Tiers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tiers entity.');
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
    * Creates a form to edit a Tiers entity.
    *
    * @param Tiers $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tiers $entity)
    {
        $this->get('session')->get('structure');

        $form = $this->createForm(new StagiaireType($id), $entity, array(
            'action' => $this->generateUrl('stagiaire_update', array('id' => $entity->getTrsId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Tiers entity.
     *
     * @Route("/{id}", name="stagiaire_update")
     * @Method("PUT")
     * @Template("::Stagiaire\edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Tiers')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tiers entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('stagiaire_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Tiers entity.
     *
     * @Route("/{id}", name="stagiaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CEOFESABundle:Tiers')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tiers entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('stagiaire'));
    }

    /**
     * Creates a form to delete a Tiers entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stagiaire_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
