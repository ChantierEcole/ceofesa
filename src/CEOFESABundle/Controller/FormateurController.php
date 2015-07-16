<?php

namespace CEOFESABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CEOFESABundle\Entity\Tiers;
use CEOFESABundle\Form\Type\TiersType;

/**
 * Tiers controller.
 *
 * @Route("/formateur")
 */
class FormateurController extends Controller
{

    /**
     * Lists all Tiers entities.
     *
     * @Route("/liste", name="formateur_list")
     * @Method("GET")
     * @Template("::Formateur\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');
        $entities = $em->getRepository('CEOFESABundle:Tiers')->getStructureFormateurs($id)->getQuery()->getResult();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Tiers entity.
     *
     * @Route("/ajout", name="formateur_create")
     * @Method({"GET","POST"})
     * @Template("::Formateur\new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tiers();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $typeFormateur = $this->getDoctrine()->getEntityManager()->getRepository('CEOFESABundle:TiersT')->getFormateurType()->getQuery()->getSingleResult();
            $entity->setTrsType($typeFormateur);
            $entity->setTrsFonction("Formateur");

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('formateur_show', array('id' => $entity->getTrsId())));
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

        $form = $this->createForm(new TiersType($id), $entity, array(
            'action' => $this->generateUrl('formateur_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Tiers entity.
     *
     * @Route("/new", name="formateur_new")
     * @Method("GET")
     * @Template("::Formateur\new.html.twig")
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
     * @Route("/{id}", name="formateur_show")
     * @Method("GET")
     * @Template("::Formateur\show.html.twig")
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
     * @Route("/{id}/edit", name="formateur_edit")
     * @Method("GET")
     * @Template("::Formateur\edit.html.twig")
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
        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new TiersType($id), $entity, array(
            'action' => $this->generateUrl('formateur_update', array('id' => $entity->getTrsId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Tiers entity.
     *
     * @Route("/{id}", name="formateur_update")
     * @Method("PUT")
     * @Template("::Formateur\edit.html.twig")
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

            return $this->redirect($this->generateUrl('formateur_show', array('id' => $id)));
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
     * @Route("/{id}", name="formateur_delete")
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

        return $this->redirect($this->generateUrl('formateur'));
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
            ->setAction($this->generateUrl('formateur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr' => array('class' => 'confirmjq')))
            ->getForm()
        ;
    }
}
