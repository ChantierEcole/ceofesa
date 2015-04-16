<?php

namespace CEOFESABundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
    * @Route(
    *       path="/",
    *       name="redirect-root"
    * )
    * @Method("GET")
    */
    public function redirectAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('dashboard'));
        } else if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')){
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        
    }

    /**
    * @Route(
    *       path="/dashboard",
    *       name="dashboard"
    * )
    * @Method("GET")
    */
    public function dashboardAction()
    {
        return $this->render("Main/dashboard.html.twig");
    }

}