<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    */
    public function validAjaxAction(Request $request){
        $DevisId = $request->request->get('id');

        return new Response($DevisId);
        
    }

    /**
	* Traitement ajax validation devis
    *
    * @Route(
    * 	path="/devis/refuse",
    * 	name="devis_refuse"
    * )
    */
    public function refuseAjaxAction(Request $request){

    }
}
