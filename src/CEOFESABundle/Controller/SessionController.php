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
use CEOFESABundle\Entity\Presence;
use CEOFESABundle\Repository\ParcoursRepository;
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
       	$form = $this->createChooseForm('session_list');

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
    	$form = $this->createChooseForm('session_list');

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

        $form2 = $this->createParticipantForm($of->getStrId(),$module->getModId(),$modType->getMtyId());

		return array(
		    'choose_form' => $form->createView(),
            'participant_form' => $form2->createView(),
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
        $form = $this->createChooseForm('session_list');

        $this->checkStructure($session);

        $id = $this->get('session')->get('structure');

        $em = $this->getDoctrine()->getManager();
        $formateurs = $em->getRepository('CEOFESABundle:Tiers')->getStructureFormateurs($id)->getQuery()->getResult();
        $moduleEntity = $em->getRepository('CEOFESABundle:Module')->find($module);
        $modtypeEntity = $em->getRepository('CEOFESABundle:ModuleT')->find($type);
        $ofEntity = $em->getRepository('CEOFESABundle:Structure')->find($of);
        $sessions = $em->getRepository('CEOFESABundle:Session')->getSessions($module,$type,$of,$id)->getQuery()->getResult();

        $form2 = $this->createParticipantForm($of,$module,$type);

        return array(
            'choose_form' => $form->createView(),
            'participant_form' => $form2->createView(),
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
    private function createChooseForm($actionURL)
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
        	->setAction($this->generateUrl($actionURL))
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
     * Création d'un formulaire pour choisir les participants d'une session
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createParticipantForm($of,$module,$moduletype)
    {
        $id = $this->get('session')->get('structure');
        $em = $this->getDoctrine()->getManager();
        //$parcours = $em->getRepository('CEOFESABundle:Parcours')->getParcours($id,$of,$module,$moduletype)->getQuery()->getResult();


        $data = array();
        $formBuilder = $this->createFormBuilder($data)
            ->add('participant','entity',array(
                'class' => 'CEOFESABundle\Entity\Parcours',
                'property' => 'prctiersdaf',
                'label' => 'Participant',
                'multiple' => false,
                'query_builder' => function(ParcoursRepository $repo) use ($id,$of,$module,$moduletype) {
                    return $repo->getParcours($id,$of,$module,$moduletype);
                },
            ))
            ->add('nbHeures','time',array(
                'label' => "Nombre d'heures",
                'widget' => 'text',
                'input'  => 'string',
            ))
        ;
        $formBuilder
            ->setAction($this->generateUrl('session_list'))
            ->setMethod('POST')
        ;

        $form = $formBuilder->getForm();

        return $form;
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

    /**
     * Page sélection par stagiaires
     *
     * @Route("/stagiaires", name="session_stagiaires")
     * @Method({"GET","POST"})
     * @Template("::Session\index_stagiaires.html.twig")
     */
    public function indexStagiairesAction(Request $request)
    {
        $form = $this->createChooseForm('session_stagiaire_list');
        
        return array(
            'choose_form' => $form->createView(),
        );
    }

    /**
    * Affiche la liste des sessions d'un stagiaire en fonction du module/moduleType/OF choisi dans le formulaire
    *
    * @Route(
    *   path="/stagiaire/list",
    *   name="session_stagiaire_list"
    * )
    * @Method({"POST"})
    * @Template("::Session\index_stagiaires.html.twig")
    */
    public function stagiaireListAction(Request $request)
    {
        $form = $this->createChooseForm('session_stagiaire_list');

        $form->handleRequest($request);
        // data is an array
        $data = $form->getData();
        $module = $data['module'];
        $modType = $data['type'];
        $of = $data['of'];
        $id = $this->get('session')->get('structure');

        $em = $this->getDoctrine()->getManager();
        $formateurs = $em->getRepository('CEOFESABundle:Tiers')->getStructureFormateurs($id)->getQuery()->getResult();
        $participants = $em->getRepository('CEOFESABundle:Parcours')->getParcours($id,$of,$module,$modType)->getQuery()->getResult();
        $entities = $em->getRepository('CEOFESABundle:Session')->getSessions($module->getModId(),$modType->getMtyId(),$of->getStrId(),$id)->getQuery()->getResult();

        $form2 = $this->createParticipantForm($of->getStrId(),$module->getModId(),$modType->getMtyId());

        return array(
            'choose_form' => $form->createView(),
            'participants' => $participants,
            'entities' => $entities,
            'module' => $module,
            'type' => $modType,
            'of' => $of,
            'formateurs' => $formateurs,
        );
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
     * -> recalcule la durée de la session en fonction de l'heure de début et de l'heure de fin
     * 
     * @Route("/auto-heure-ajax", name="auto_heure_ajax")
     *
     */
    public function calculDureeAjaxAction(Request $request){

        $heureDebut = $request->request->get('heureDebut');
        $heureFin = $request->request->get('heureFin');
        $minuteDebut = $request->request->get('minuteDebut');
        $minuteFin = $request->request->get('minuteFin');

        if(!empty($heureDebut) && !empty($heureFin) && !empty($minuteDebut) && !empty($minuteFin)){
            $dateDebut = new \DateTime($heureDebut.':'.$minuteDebut.':00');
            $dateFin = new \DateTime($heureFin.':'.$minuteFin.':00');
            $interval = $dateFin->diff($dateDebut);
            $result = $interval->format('%h,%i');
        } else {
            $result = "0,00";
        }

        return new JsonResponse($result);
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
     * -> affichage des participants d'une session choisie
     * 
     * @Route("/participants-ajax", name="participants_session_ajax")
     *
     */
    public function participantsSessionAjaxAction(Request $request){

        $sessionId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $participants = $em->getRepository('CEOFESABundle:Presence')->getPresencesSession($sessionId)->getQuery()->getResult();
        $reponse = array();
        foreach ($participants as $participant) {
            $p = array();
            $p['id'] = $participant->getPscId();
            $stagiaire = $participant->getPscParcours()->getPrcDcont()->getCntTiers();
            $p['stagiaire'] = $stagiaire->getTrsNom().' '.$stagiaire->getTrsPrenom();
            $p['nbheures'] = $participant->getPscDuree();
            $p['daf'] = $participant->getPscParcours()->getPrcDcont()->getCntDaf()->getDafDossier();
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
                'Aucun formateur trouvé pour cette session. (id liaison : '.$id.')'
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
    public function formateurAddAjaxAction(Request $request){

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
     * Traitement backoffice de l'AJAX
     * -> suppression du participant choisi
     * 
     * @Route("/participant-delete-ajax", name="participant_delete_ajax")
     *
     */
    public function participantDeleteAjaxAction(Request $request){
        $presenceId = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $presence = $em->getRepository('CEOFESABundle:Presence')->find($presenceId);

        if (!$presence) {
            throw $this->createNotFoundException(
                'Aucun participant trouvé pour cette session. (id liaison : '.$id.')'
            );
        }

        $sessionid = $presence->getPscSession()->getSesId();
        $em->remove($presence);
        $em->flush();

        return new JsonResponse($sessionid);
    }

    /**
     * Traitement backoffice de l'AJAX
     * -> ajout d'un participant à la session
     * 
     * @Route("/participant-add-ajax", name="participant_add_ajax")
     *
     */
    public function participantAddAjaxAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $duree = $request->request->get('duree');
        $idsession = $request->request->get('idsession');
        $session = $em->getRepository('CEOFESABundle:Session')->find($idsession);
        $idparcours = $request->request->get('idparcours');
        $parcours = $em->getRepository('CEOFESABundle:Parcours')->find($idparcours);
        $dcont = $parcours->getPrcDcont()->getCntId();
        $dureeOK = preg_match("/(^[01]?[0-9]|2[0-3])\.[0-5][0-9]/", $duree);
        $presenceExist = $em->getRepository('CEOFESABundle:Presence')->getPresence($idsession,$idparcours)->getQuery()->getResult();
        $limiteOK = $this->checkTotalHeures($dcont,$duree);

        if(!$dureeOK){
            $response = new JsonResponse('duree', 419);
        }elseif($presenceExist) {
            $response = new JsonResponse('doublon', 419);
        }elseif(!$limiteOK) {
            $response = new JsonResponse('limite', 419);
        }else{
            $presence = new Presence();
            $presence->setPscDuree($duree);
            $presence->setPscFacture(0);
            $presence->setPscSession($session);
            $presence->setPscParcours($parcours);
            $em->persist($presence);
            $em->flush();
            $response = new JsonResponse($idsession); 
        }

        return $response;
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

    /*
    * Fonction pour vérifer si la somme des durées saisies pour une DAF pour un stagiaire ne dépasse pas la somme des heures prévues dans les parcours pour cette DAF/stagiaire (DCont)
    */
    private function checkTotalHeures($dcont,$nextDuree=0){

        $em = $this->getDoctrine()->getManager();
        $nbHeuresRealisees = $em->getRepository('CEOFESABundle:Presence')->getDcontTotalDurees($dcont);
        $nbHeuresPrevues = $em->getRepository('CEOFESABundle:Parcours')->getDcontTotalHeures($dcont);
        
        $nbHeuresRealisees += $nextDuree;

        if($nbHeuresRealisees <= $nbHeuresPrevues){
            return true;
        } else {
            return false;
        }
    }
}