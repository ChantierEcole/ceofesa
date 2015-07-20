<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CEOFESABundle\Repository\StructureRepository;
use CEOFESABundle\Entity\Session;
use CEOFESABundle\Entity\Animation;
use CEOFESABundle\Form\Type\SessionType;


/**
 * Session controller.
 *
 * @Route("/session")
 */
class SessionController extends Controller
{
	/**
    * @Route(
    * 	path="/",
    * 	name="session_index"
    * )
    * @Method({"GET"})
    * @Template("::Session\index.html.twig")
    */
    public function indexAction(Request $request)
    {
       	$form = $this->createChooseForm();

        return array(
            'choose_form' => $form->createView(),
        );
    }

     /**
     * Creates a new Session entity.
     *
     * @Route("/ajout/{module}/{type}/{of}", name="session_create")
     * @Method({"GET","POST"})
     * @Template("::Session\new.html.twig")
     */
    public function createAction(Request $request,$module,$type,$of)
    {
        $entity = new Session();
        $form = $this->createCreateForm($entity,$module,$type,$of);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $id = $entity->getSesId();

            return $this->redirect($this->generateUrl('session_list2', array('module' => $module,'type' => $type,'of' => $of, 'session' => $id)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Session entity.
     *
     * @param Session $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Session $entity,$module,$type,$of)
    {
        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new SessionType($id,$module,$type,$of), $entity, array(
            'action' => $this->generateUrl('session_create', array('module' => $module,'type' => $type,'of' => $of)),
            'method' => 'POST',
        ));

        return $form;
    }

   /**
    * Affiche la liste des sessions en fonction du module/moduleType/OF choisi dans le formulaire
    *
    * @Route(
    * 	path="/list",
    * 	name="session_list"
    * )
    * @Method({"POST"})
    * @Template("::Session\index.html.twig")
    */
    public function listAction(Request $request)
    {
    	$form = $this->createChooseForm();

    	$form->handleRequest($request);
        // data is an array
        $data = $form->getData();
        $module = $data['module'];
        $modType = $data['type'];
        $of = $data['of'];
        $id = $this->get('session')->get('structure');

        $em = $this->getDoctrine()->getManager();
        $formateurs = $em->getRepository('CEOFESABundle:Tiers')->getStructureFormateurs($id)->getQuery()->getResult();
        $entities = $em->getRepository('CEOFESABundle:Session')->getSessions($module->getModId(),$modType->getMtyId(),$of->getStrId(),$id)->getQuery()->getResult();

		return array(
		    'choose_form' => $form->createView(),
		    'entities' => $entities,
		    'module' => $module,
		    'type' => $modType,
		    'of' => $of,
            'formateurs' => $formateurs,
		);
	}

    /**
    * Affiche la liste des sessions après ajout ou modification d'une session
    *
    * @Route(
    *   path="/list/{module}/{type}/{of}/{session}",
    *   name="session_list2"
    * )
    * @Method({"GET"})
    * @Template("::Session\index.html.twig")
    */
    public function validBackListAction($module, $type, $of, $session)
    {
        $form = $this->createChooseForm();

        $this->checkStructure($session);

        $id = $this->get('session')->get('structure');

        $em = $this->getDoctrine()->getManager();
        $formateurs = $em->getRepository('CEOFESABundle:Tiers')->getStructureFormateurs($id)->getQuery()->getResult();
        $moduleEntity = $em->getRepository('CEOFESABundle:Module')->find($module);
        $modtypeEntity = $em->getRepository('CEOFESABundle:ModuleT')->find($type);
        $ofEntity = $em->getRepository('CEOFESABundle:Structure')->find($of);
        $sessions = $em->getRepository('CEOFESABundle:Session')->getSessions($module,$type,$of,$id)->getQuery()->getResult();

        return array(
            'choose_form' => $form->createView(),
            'entities' => $sessions,
            'module' => $moduleEntity,
            'type' => $modtypeEntity,
            'of' => $ofEntity,
            'formateurs' => $formateurs,
            'session' => $session,
        );
    }

    /**
     * Création d'un formulaire pour choisir les "paramètres" des sessions à afficher
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createChooseForm()
    {
        $id = $this->get('session')->get('structure');
        $em = $this->getDoctrine()->getManager();

        $data = array();
        $formBuilder = $this->createFormBuilder($data)
            ->add('module','entity',array(
                'class' => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'multiple' => false,
            ))
            ->add('type','entity',array(
                'class' => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'multiple' => false,
            ))
            ->add('of','choice',array(
                'required'  => true,
                'multiple'  => false,
                'empty_value' => '',
            ))
            ->add('voir','submit', array(
                'attr' => array('class' => 'btn-primary')
            ))
        ;
        $formBuilder
        	->setAction($this->generateUrl('session_list'))
			->setMethod('POST')
		;

        $formBuilder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
    		$formulaire = $event->getForm();
    		$data = $event->getData();

    		$ofId = $data['of'];
        	if($ofId != null){ 
            $formulaire->remove('of');
            $formulaire->add('of','entity',array(
	                'class' => 'CEOFESABundle\Entity\Structure',
	                'property' => 'strNom',
	                'label' => 'OF',
	                'multiple' => false,
	                'query_builder' => function(StructureRepository $repo) use ($ofId) {
	                    return $repo->getStructure($ofId);
	                }
	            ));
	        }

        });

        $form = $formBuilder->getForm();

        return $form;
    }

    /**
     * Traitement backoffice de l'AJAX
     * -> affichage de la listes des OF en fonction du module et du type
     * 
     * @Route("/ajax", name="session_ajax")
     *
     */
    public function sessionAjaxAction(Request $request){

        $moduleId = $request->request->get('module_id');
        $typeId = $request->request->get('type_id');
        $id = $this->get('session')->get('structure');
        $em = $this->getDoctrine()->getManager();

        $rep = $em->getRepository('CEOFESABundle:Session')->getOFs($moduleId, $typeId, $id);

        $structures = $rep->getQuery()->getResult();

        $OFList = array();

        foreach ($structures as $structure) {
            $p = array();
            $p['id'] = $structure->getSesOf()->getStrId();
            $p['nom'] = $structure->getSesOf()->getStrNom();
            $OFList[] = $p;
        }

        return new JsonResponse($OFList);
    }

    /**
     * Traitement backoffice de l'AJAX
     * -> affichage du détail d'une session choisie
     * 
     * @Route("/detail-ajax", name="details_session_ajax")
     *
     */
    public function detailsSessionAjaxAction(Request $request){

        $sessionId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $session = $em->getRepository('CEOFESABundle:Session')->find($sessionId);
        $reponse = array();
        $reponse['id']= $sessionId;
        $reponse['date']= date_format($session->getSesDate(), 'd-m-Y');
        $reponse['hDebut']= $session->getSesHeuredebut();
        $reponse['hFin']= $session->getSesHeurefin();
        $reponse['duree']= $session->getSesDuree();
        $reponse['seance']= $session->getSesStype()->getStyType();
        $reponse['formation']= $session->getSesFtype()->getFtyType();

        return new JsonResponse($reponse);
    }

    /**
     * Traitement backoffice de l'AJAX
     * -> affichage des formateurs d'une session choisie
     * 
     * @Route("/formateur-ajax", name="formateurs_session_ajax")
     *
     */
    public function formateursSessionAjaxAction(Request $request){

        $sessionId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $formateurs = $em->getRepository('CEOFESABundle:Animation')->getFormateurs($sessionId)->getQuery()->getResult();
        $reponse = array();
        foreach ($formateurs as $formateur) {
            $p = array();
            $p['id'] = $formateur->getAniId();
            $p['tiers'] = $formateur->getAniTiers()->getTrsNom().' '.$formateur->getAniTiers()->getTrsPrenom();
            $reponse[] = $p;
        }

        return new JsonResponse($reponse);
    }

    /**
     * Traitement backoffice de l'AJAX
     * -> suppression du formateur choisi
     * 
     * @Route("/formateur-delete-ajax", name="formateur_delete_ajax")
     *
     */
    public function formateursDeleteAjaxAction(Request $request){
        $animationId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $animation = $em->getRepository('CEOFESABundle:Animation')->find($animationId);

        if (!$animation) {
            throw $this->createNotFoundException(
                'Aucun formateur trouvé pour cet session. (id liaison : '.$id.')'
            );
        }

        $sessionid = $animation->getAniSession()->getSesId();
        $em->remove($animation);
        $em->flush();

        return new JsonResponse($sessionid);
    }

    /**
     * Traitement backoffice de l'AJAX
     * -> ajout d'un formateur à la session
     * 
     * @Route("/formateur-add-ajax", name="formateur_add_ajax")
     *
     */
    public function formateursAddAjaxAction(Request $request){

        $sessionid = $request->request->get('idsession');
        $formateurid = $request->request->get('idformateur');
        $em = $this->getDoctrine()->getManager();
        $session = $em->getRepository('CEOFESABundle:Session')->find($sessionid);
        $formateur = $em->getRepository('CEOFESABundle:Tiers')->find($formateurid);

        if (!$em->getRepository('CEOFESABundle:Animation')->getFormateurs($sessionid)->getQuery()->getResult()) {
            $animation = new Animation();
            $animation->setAniTiers($formateur);
            $animation->setAniSession($session);
            $em->persist($animation);
            $em->flush();
        }

        return new JsonResponse($sessionid);
    }

    /**
     * Displays a form to edit an existing Session entity.
     *
     * @Route("/edit/{id}", name="session_edit")
     * @Method({"GET","POST"})
     * @Template("::Session\edit.html.twig")
     */
    public function editAction(Request $request,$id)
    {
        $this->checkStructure($id);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Session')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver la Session demandée');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {     
            $em->flush();
            return $this->redirect($this->generateUrl('session_list2', array(
                'module' => $entity->getSesModule()->getModId(),
                'type' => $entity->getSesMtype()->getMtyId(),
                'of' => $entity->getSesOf()->getStrId(), 
                'session' => $entity->getSesId(),
            )));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Session entity.
    *
    * @param Session $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Session $entity)
    {
        $idstructure = $this->get('session')->get('structure');
        $idsession = $entity->getSesId();
        $module = $entity->getSesModule()->getModId();
        $type = $entity->getSesMtype()->getMtyId();
        $of = $entity->getSesOf()->getStrId();

        $form = $this->createForm(new SessionType($idstructure,$module,$type,$of), $entity, array(
            'action' => $this->generateUrl('session_edit', array('id' => $idsession)),
            'method' => 'POST',
        ));

        return $form;
    }
    
    /**
     * Deletes a Session entity.
     *
     * @Route("/{id}/delete", name="session_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $this->checkStructure($id);

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CEOFESABundle:Session')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Session entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('session'));
    }

    /**
     * Creates a form to delete a Devis entity by id.
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
    * Fonction pour vérifer si l'id de la structure de la session de formation correspond bien à la structure de la session en cours
    */
    private function checkStructure($id){

        $em = $this->getDoctrine()->getManager();
        $structure = $em->getRepository('CEOFESABundle:Session')->getStructureSession($id);

         if ($structure != $this->get('session')->get('structure')) {
            throw new NotFoundHttpException("Vous n'avez pas les droits nécessaires pour accéder à la page demandée");
        }
    }
}