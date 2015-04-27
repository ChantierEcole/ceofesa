<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
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

        $validForm = $this->createValidForm();
        $refuseForm = $this->createRefuseForm();

        return $this->render("Devis/admin.html.twig",array(
        	'entities' => $entities,
        	'valid_form' => $validForm->createView(),
        	'refuse_form' => $refuseForm->createView(),
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
    public function validAjaxAction(Request $request, $id){

    }

    /**
	* Traitement ajax validation devis
    *
    * @Route(
    * 	path="/devis/refuse",
    * 	name="devis_refuse"
    * )
    */
    public function refuseAjaxAction(Request $request, $id){

    }

    /**
	* Creates a form to valid a Devis entity by id.
	*
	* @param mixed $id The entity id
	*
	* @return \Symfony\Component\Form\Form The form
	*/
	private function createValidForm()
	{
	    return $this->createFormBuilder()
	        ->setAction($this->generateUrl('devis_valid'))
	        ->add('submit', 'submit', array('label' => 'Valider','attr' => array('class' => 'btn btn-green3')))
	        ->getForm()
	    ;
	}

	/**
	* Creates a form to refuse a Devis entity by id.
	*
	* @param mixed $id The entity id
	*
	* @return \Symfony\Component\Form\Form The form
	*/
	private function createRefuseForm()
	{
	    return $this->createFormBuilder()
	        ->setAction($this->generateUrl('devis_refuse'))
	        ->add('submit', 'submit', array('label' => 'Refuser','attr' => array('class' => 'btn btn-red3')))
	        ->getForm()
	    ;
	}	
}
