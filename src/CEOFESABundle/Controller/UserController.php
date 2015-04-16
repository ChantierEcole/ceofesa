<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use CEOFESABundle\Form\Domain\utilisateur;
use CEOFESABundle\Form\Type\UtilisateurType;

class UserController extends Controller
{
    /**
    * @Route(
    *       path="/login/new",
    *       name="login_new"
    * )
    * @Method({"GET","POST"})
    */
    public function loginNewAction(Request $request)
    {
        $utilisateur = new utilisateur();
        $form = $this->createForm(new UtilisateurType(),$utilisateur);
        $form -> handleRequest($request);

        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Demande de compte')
                ->setFrom('webmestre@chantierecole.org')
                ->setTo('webmestre@chantierecole.org')
                ->setBody($this->renderView('Contact\utilisateur.txt.twig',array('utilisateur' => $utilisateur)))
            ;
            $this->get('mailer')->send($message);

            echo 'le formulaire est valide et un mail a été envoyé';
        }

        return $this->render("User/loginnew.html.twig",array('form' => $form->createView()));
    }

    /**
    * @Route(
    *       path="/users/gestion",
    *       name="users_gestion"
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
}
