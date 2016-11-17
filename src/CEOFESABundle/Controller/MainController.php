<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Entity\Parcours;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $form = $this->createForm('dashboard_type');

        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $start = $data['start'];
            $end = $data['end'];

            if ($form->get('print')->isClicked()) {
                $response= new Response();
                $response->setContent($this->get('ceofesa.dashboard.exporter')->exportPdf($structure, $start, $end));
                $response->headers->set('Content-Type', 'application/pdf');
                $response->headers->set(
                    'Content-disposition',
                    'filename=SyntheseMensuelle-'.$start->format('m-Y').'-'.$end->format('m-Y').'.pdf'
                );

                return $response;
            }

            if ($form->has('export') && $form->get('export')->isClicked()) {
                $response= new Response();
                $response->setContent($this->get('ceofesa.dashboard.exporter')->exportCsv($structure, $start, $end));
                $response->headers->set('Content-Type', 'application/csv');
                $response->headers->set(
                    'Content-disposition',
                    'filename=SyntheseMensuelle-'.$start->format('m-Y').'-'.$end->format('m-Y').'.csv'
                );

                return $response;
            }
        } else {
            $form->get('start')->setData($start = new \DateTime(date('Y-m-01 00:00:00')));
            $form->get('end')->setData($end = new \DateTime(date('Y-m-t 23:59:59')));
        }

        return $this->render("Main/structure_dashboard.html.twig", array(
            'participants' => $em->getRepository('CEOFESABundle:Parcours')->getParcoursByStructureAndDate($id, $start, $end),
            'structure'    => $structure,
            'form'         => $form->createView(),
        ));
    }

    /**
     * @Route(
     *     path = "/ma-structure",
     *     name = "detail_ma_structure"
     * )
     *
     * @Template("::Main\detail_ma_structure.html.twig")
     *
     * @return array
     */
    public function detailMaStructureAction()
    {
        $structure = $this->get('security.context')->getToken()->getUser()->getStructure();

        return array('entity' => $structure);
    }
}
