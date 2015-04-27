<?php

namespace CEOFESABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CEOFESABundle\Entity\Structure;
use CEOFESABundle\Form\Type\SoustraitantType;

/**
 * Structure controller.
 *
 * @Route("/soustraitant")
 */
class SoustraitantController extends Controller
{

    /**
     * Lists all Structure entities.
     *
     * @Route("/liste", name="soustraitant_list")
     * @Method({"GET","POST"})
     * @Template("::Soustraitant\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('security.context')->getToken()->getUser()->getStructure();

        $entities = $em->getRepository('CEOFESABundle:Structure')->getSoustraitants($id)->getQuery()->getResult();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Structure entity.
     *
     * @Route("/ajout", name="soustraitant_create")
     * @Method({"GET","POST"})
     * @Template("::Soustraitant\new.html.twig")
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

            return $this->redirect($this->generateUrl('soustraitant_show', array('id' => $entity->getId())));
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
        $form = $this->createForm(new SoustraitantType(), $entity, array(
            'action' => $this->generateUrl('soustraitant_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Structure entity.
     *
     * @Route("/new", name="soustraitant_new")
     * @Method("GET")
     * @Template("::Soustraitant\new.html.twig")
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
     * @Route("/{id}", name="soustraitant_show")
     * @Method("GET")
     * @Template("::Soustraitant\show.html.twig")
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
     * @Route("/{id}/edit", name="soustraitant_edit")
     * @Method("GET")
     * @Template("::Soustraitant\edit.html.twig")
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
        $form = $this->createForm(new SoustraitantType(), $entity, array(
            'action' => $this->generateUrl('soustraitant_update', array('id' => $entity->getStrId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Structure entity.
     *
     * @Route("/{id}", name="soustraitant_update")
     * @Method("PUT")
     * @Template("::Soustraitant\edit.html.twig")
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

            return $this->redirect($this->generateUrl('soustraitant_show', array('id' => $id)));
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
     * @Route("/{id}", name="soustraitant_delete")
     * @Method("DELETE")
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

        return $this->redirect($this->generateUrl('soustraitant'));
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
            ->setAction($this->generateUrl('soustraitant_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
