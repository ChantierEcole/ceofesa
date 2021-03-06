<?php

namespace CEOFESABundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CEOFESABundle\Entity\Devis;
use CEOFESABundle\Form\Type\DevisType;

/**
 * Devis controller
 *
 * @Route("/devis")
 */
class DevisController extends Controller
{
    /**
     * Liste des devis
     *
     * @Route("/", name="devis")
     * @Method("GET")
     * @Template("::Devis\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        $entities = $em->getRepository('CEOFESABundle:Devis')->getDevisStructure($id)->getQuery()->getResult();

        return array(
            'devis' => $entities,
        );
    }

    /**
     * Gestion de l'envoi d'un formulaire de création d'une entité Devis
     *
     * @Route("/", name="devis_create")
     * @Method("POST")
     * @Template("::Devis\new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Devis();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $numDevis = $this->getDoctrine()->getEntityManager()->getRepository('CEOFESABundle:Devis')->getNextNum();
            $entity->setDevNumero($numDevis);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Demande de devis')
                ->setFrom($this->get('session')->get('mail'))
                ->setTo(array($this->container->getParameter('contact_mail1'),$this->container->getParameter('contact_mail2'),$this->container->getParameter('contact_mail3'),$this->container->getParameter('contact_mail4')))
                ->setBody($this->renderView('Mail\devis.txt.twig',array('devis' => $entity)))
            ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('devis_show', array('id' => $entity->getDevId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Formulaire pour la création d'une entité Devis
     *
     * @param Devis $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Devis $entity)
    {
        // Tarif défini dans /src/CEOFESABundle/Resources/config/parameters.yml
        $tarif = $this->container->getParameter('tarif_ofesa');
        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new DevisType($id,$tarif), $entity, array(
            'action' => $this->generateUrl('devis_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Affichage du formulaire pour créer une nouvelle entité Devis
     *
     * @Route("/new", name="devis_new")
     * @Method("GET")
     * @Template("::Devis\new.html.twig")
     */
    public function newAction()
    {
        $entity = new Devis();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Traitement backoffice de l'AJAX.
     * 
     * @Route("/ajax", name="devis_ajax")
     *
     */
    public function devisAjaxAction(Request $request){

        $typeId = $request->request->get('type_id');
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        /* sélectionne toutes les structures selon leur type (intra/externe) */
        if($typeId == '0'){
            $rep = $em->getRepository('CEOFESABundle:Structure')->getIntra();
        }elseif($typeId == '1'){
            $rep = $em->getRepository('CEOFESABundle:Structure')->getSoustraitants($id);
        }
        $structures = $rep->getQuery()->getResult();

        /* On créer un tableau avec l'ID et le nom de toutes les structures choisies pour le renvoyer */
        $OFList = array();
        foreach ($structures as $structure) {
            $p = array();
            $p['id'] = $structure->getStrId();
            $p['nom'] = $structure->getStrNom();
            $OFList[] = $p;
        }
        return new JsonResponse($OFList);
    }

    /**
     * Affiche les détails d'une entité Devis
     *
     * @Route("/{id}", name="devis_show")
     * @Method("GET")
     * @Template("::Devis\show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Devis')->find($id);
        $entities = $em->getRepository('CEOFESABundle:DParcours')->getParcoursDevis($id)->getQuery()->getResult();

        if (!$entity) {
            throw $this->createNotFoundException('Devis Introuvable. Désolé');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'entities' => $entities,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Affiche un formulaire pour éditer une entité Devis
     *
     * @Route("/{id}/edit", name="devis_edit")
     * @Method("GET")
     * @Template("::Devis\edit.html.twig")
     */
    public function editAction($id)
    {
        $this->checkStructure($id);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Devis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver le devis demandé');
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
    * Créer un formulaire pour éditer une entité Devis
    *
    * @param Devis $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Devis $entity)
    {
        // Tarif défini dans /src/CEOFESABundle/Resources/config/parameters.yml
        $tarif = $this->container->getParameter('tarif_ofesa');
        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new DevisType($id,$tarif), $entity, array(
            'action' => $this->generateUrl('devis_update', array('id' => $entity->getDevId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Gestion de l'envoi d'un formulaire d'édition d'une entité Devis
     *
     * @Route("/{id}", name="devis_update")
     * @Method("PUT")
     * @Template("::Devis\edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $this->checkStructure($id);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Devis')->find($id);
        $entity->setDevStatut('en cours');
        $entity->setDevDatedevis(new \DateTime());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Devis entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {     
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Modification d\'un devis')
                ->setFrom($this->get('session')->get('mail'))
                ->setTo(array($this->container->getParameter('contact_mail1'),$this->container->getParameter('contact_mail2'),$this->container->getParameter('contact_mail3'),$this->container->getParameter('contact_mail4')))
                ->setBody($this->renderView('Mail\modifDevis.txt.twig',array('devis' => $entity)))
            ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('devis_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Action de suppression d'une entité Devis
     *
     * @Route("/{id}", name="devis_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $this->checkStructure($id);
        $this->checkValid($id);

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CEOFESABundle:Devis')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Devis entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('devis'));
    }

    /**
     * Création d'un formulaire pour supprimer une entité Devis en fonction de son id
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('devis_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr' => array('class' => 'btn btn-red2 confirmjq')))
            ->getForm()
        ;
    }

    /*
    * Fonction pour vérifer si l'id de la structure du devis correspond bien à la structure de la session
    */
    private function checkStructure($id){

        $em = $this->getDoctrine()->getManager();
        $structure = $em->getRepository('CEOFESABundle:Devis')->getStructureDevis($id);

         if ($structure != $this->get('session')->get('structure')) {
            throw new NotFoundHttpException("Vous n'avez pas les droits nécessaires pour accéder à la page demandée");
        }
    }

    /*
    * Fonction pour vérifier si le statut d'un devis est bien à "Validé"
    */
    private function checkValid($id){

        $em = $this->getDoctrine()->getManager();
        $statut = $em->getRepository('CEOFESABundle:Devis')->getStatutDevis($id);

         if ($statut == "Validé") {
            throw new NotFoundHttpException("Le statut de ce devis ne permet pas d'accéder à la page demandée");
        }
    }

    /**
     * Génère un PDF de Devis à l'aide de la vue Templates/devis.html.twig
     *
     * @Route("/{id}/pdf", name="devis_print")
     */
    public function printDevisAction($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $stagiaires = $em->getRepository('CEOFESABundle:DParcours')->getStagiairesDevis($id)->getQuery()->getResult();
        $parcours = $em->getRepository('CEOFESABundle:DParcours')->getParcoursDevis($id)->getQuery()->getResult();
        $devis = $em->getRepository('CEOFESABundle:Devis')->find($id); 

        $html = $this->renderView('::Templates\devis.html.twig', array(
            'id' => $id,
            'stagiaires' => $stagiaires,
            'parcours' => $parcours,
            'devis' => $devis,
        ));

        $response= new Response();
        $response->setContent($this->get('knp_snappy.pdf')->getOutputFromHtml($html,array('orientation' => 'Portrait','page-size' => 'A4')));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename=devis.pdf');

        return $response;
    }

    /**
     * Génère un PDF d'attestation d'inscription à l'aide de la vue Templates/attestation-inscription.html.twig
     *
     * @Route("/{id}/pdf/attestation", name="attestation_print")
     */
    public function printAttestationAction($id)
    {   
        $em = $this->getDoctrine()->getManager();
        $stagiaires = $em->getRepository('CEOFESABundle:DParcours')->getStagiairesDevis($id)->getQuery()->getResult();
        $parcours = $em->getRepository('CEOFESABundle:DParcours')->getParcoursDevis($id)->getQuery()->getResult();
        $devis = $em->getRepository('CEOFESABundle:Devis')->find($id); 

        $html = $this->renderView('::Templates\attestation-inscription.html.twig', array(
            'id' => $id,
            'stagiaires' => $stagiaires,
            'parcours' => $parcours,
            'devis' => $devis,
        ));

        $response= new Response();
        $response->setContent($this->get('knp_snappy.pdf')->getOutputFromHtml($html,array('orientation' => 'Portrait')));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename=attestation.pdf');

        return $response;
    }
}
