<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use CEOFESABundle\Form\Domain\utilisateur;
use CEOFESABundle\Form\Type\UtilisateurType;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
	/**
    * @Route(
    * 	path="/users",
    * 	name="users_gestion"
    * )
    * @Method({"GET","POST"})
    */
    public function userGestionAction(Request $request)
    {
        // Pour récupérer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');

        // Pour récupérer la liste de tous les utilisateurs
        $users = $userManager->findUsers();
        
        return $this->render("User/gestion.html.twig",array('users'=>$users));
    }

	/**
	* Liste les devis en cours
    *
    * @Route(
    * 	path="/devis",
    * 	name="devis_gestion"
    * )
    */
    public function devisGestionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CEOFESABundle:Devis')->getDevisEnCours();

        return $this->render("Devis/admin.html.twig",array(
        	'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Devis entity for admin
     *
     * @Route("/devis/{id}", name="devis_admin_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Devis')->find($id);
        $entities = $em->getRepository('CEOFESABundle:DParcours')->getParcoursDevis($id)->getQuery()->getResult();

        if (!$entity) {
            throw $this->createNotFoundException('Devis Introuvable. Désolé');
        }

        return $this->render("Devis/adminShow.html.twig",array(
            'entity'      => $entity,
            'entities' => $entities,
        ));
    }

    /**
	* Traitement ajax validation devis
    *
    * @Route(
    * 	path="/devis/valid",
    * 	name="devis_valid"
    * )
    * @Method("POST")
    */
    public function validAjaxAction(Request $request){

        $DevisId = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $devis = $em->getRepository('CEOFESABundle:Devis')->find($DevisId);
        $devstructure = $devis->getDevstructure();
        $mails = $em->getRepository('CEOFESABundle:Utilisateurs')->getMails($devstructure);

        if (!$devis) {
            throw $this->createNotFoundException(
                'Aucun devis trouvé pour cet id : '.$id
            );
        }

        $devis->setDevStatut('Validé');
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Votre devis a été validé')
            ->setFrom($this->container->getParameter('contact_mail1'))
            ->setTo($mails)
            ->setBody($this->renderView('Mail\validDevis.txt.twig',array('devis' => $devis)))
        ;
        $this->get('mailer')->send($message);

        return new Response($DevisId);
    }

    /**
	* Traitement ajax refus devis
    *
    * @Route(
    * 	path="/devis/refuse",
    * 	name="devis_refuse"
    * )
    * @Method("POST")
    */
    public function refuseAjaxAction(Request $request){

        $DevisId = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $devis = $em->getRepository('CEOFESABundle:Devis')->find($DevisId);
        $devstructure = $devis->getDevstructure();
        $mails = $em->getRepository('CEOFESABundle:Utilisateurs')->getMails($devstructure);

        if (!$devis) {
            throw $this->createNotFoundException(
                'Aucun devis trouvé pour cet id : '.$id
            );
        }

        $devis->setDevStatut('Refusé');
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Votre devis a été refusé')
            ->setFrom($this->container->getParameter('contact_mail1'))
            ->setTo($mails)
            ->setBody($this->renderView('Mail\refuseDevis.txt.twig',array('devis' => $devis)))
        ;
        $this->get('mailer')->send($message);

        return new Response($DevisId); 

    }

    /**
    * Traitement ajax liste des structures admin menu header
    *
    * @Route(
    *   path="/structure/change",
    *   name="structure_change"
    * )
    */
    public function listAjaxAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('CEOFESABundle:Structure')->getStructures();

        $structures = $query->getQuery()->getResult();
        
        $StrList = array();

        foreach ($structures as $structure) {
            $p = array();
            $p['id'] = $structure->getStrId();
            $p['nom'] = $structure->getStrNom();
            $StrList[] = $p;
        }

        return new JsonResponse($StrList);
    }

    /**
    * Traitement ajax structure sélectionnée admin menu header
    *
    * @Route(
    *   path="/structure/session",
    *   name="structure_session"
    * )
    */
    public function sessionAjaxAction(Request $request){

        $idStructure = $this->get('session')->get('structure');
        $em = $this->getDoctrine()->getManager();
        $StrSession = $em->getRepository('CEOFESABundle:Structure')->find($idStructure);
        return new Response($StrSession);

    }

    /**
    * Traitement ajax changement de structure pour la session
    *
    * @Route(
    *   path="/change/session",
    *   name="change_session"
    * )
    */
    public function changeSessionAjaxAction(Request $request){

        $structureId = $request->request->get('structure_id');
        if (!empty($structureId)) {
            $this->get('session')->set('structure', $structureId);
        }

        return new Response($this->get('session')->get('structure'));

    }
}
