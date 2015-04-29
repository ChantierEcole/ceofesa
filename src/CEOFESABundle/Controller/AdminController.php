<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        if (!$devis) {
            throw $this->createNotFoundException(
                'Aucun devis trouvé pour cet id : '.$id
            );
        }

        $devis->setDevStatut('Validé');
        $em->flush();

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

        if (!$devis) {
            throw $this->createNotFoundException(
                'Aucun devis trouvé pour cet id : '.$id
            );
        }

        $devis->setDevStatut('Refusé');
        $em->flush();

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
}
