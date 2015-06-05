<?php

namespace CEOFESABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
    * @Method({"GET","POST"})
    * @Template("::Session\index.html.twig")
    */
    public function indexAction(Request $request)
    {
       	$form = $this->createChooseForm();
		$id = $this->get('session')->get('structure');

		if ($request->isMethod('POST')) {
            $form->bind($request);

            // data is an array
            $data = $form->getData();
        }

        return array(
            'choose_form'   => $form->createView(),
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
    	$form = $this->createFormBuilder($data)
        	->add('module','entity',array(
                'class' => 'CEOFESABundle\Entity\Module',
                'property' => 'modCode',
                'multiple' => false
            ))
        	->add('type','entity',array(
                'class' => 'CEOFESABundle\Entity\ModuleT',
                'property' => 'mtyType',
                'multiple' => false
            ))
        	->add('message', 'text')
        	->add('voir','submit', array(
                'attr' => array('class' => 'btn-primary')
            ))
        	->getForm();

        return $form;
    }
}