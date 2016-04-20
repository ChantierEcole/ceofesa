<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Entity\Parcours;
use CEOFESABundle\Form\Type\DashboardType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

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

    /**
     * @Route(
     *       path="/dashboard/structure",
     *       name="structure_dashboard"
     * )
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardStructureAction(Request $request)
    {
        $id = $this->get('session')->get('structure');
        $em = $this->getDoctrine()->getManager();
        $structure = $em->getRepository('CEOFESABundle:Structure')->find($id);

        $form = $this->createForm(new DashboardType());

        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $date = $data['date'];

            if ($form->get('print')->isClicked()) {
                $participants = $em->getRepository('CEOFESABundle:Parcours')->getParcoursByStructureAndDate($id, $date);

                $html = $this->renderView('::Templates\month_recap.html.twig', array(
                    'participants' => $participants,
                    'structure'    => $structure,
                    'date'         => $date,
                ));

                $response= new Response();
                $response->setContent($this->get('knp_snappy.pdf')->getOutputFromHtml($html, array(
                    'orientation' => 'Portrait',
                    'page-size' => 'A4'
                )));
                $response->headers->set('Content-Type', 'application/pdf');
                $response->headers->set(
                    'Content-disposition',
                    'filename=SyntheseMensuelle-'.$date->format('m-Y').'.pdf'
                );

                return $response;
            }
        } else {
            $form->get('date')->setData($date = new \DateTime());
        }

        return $this->render("Main/structure_dashboard.html.twig", array(
            'date'         => $date,
            'participants' => $em->getRepository('CEOFESABundle:Parcours')->getParcoursByStructureAndDate($id, $date),
            'structure'    => $structure,
            'form'         => $form->createView(),
        ));
    }
}
