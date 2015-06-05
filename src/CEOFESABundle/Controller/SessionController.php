<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
    * @Template("::Session\index.html.twig")
    */
    public function indexAction(Request $request)
    {
       	$em = $this->getDoctrine()->getManager();
		$id = $this->get('session')->get('structure');

        $modules = $em->getRepository('CEOFESABundle:Modules')->findAll();

        return array(
            'modules' => $modules,
        );
    }
}