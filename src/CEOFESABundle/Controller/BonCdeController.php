<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Entity\BonCde;
use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\DCont;
use CEOFESABundle\Entity\Devis;
use CEOFESABundle\Entity\ModuleT;
use CEOFESABundle\Entity\Structure;
use CEOFESABundle\Form\Type\DafType;
use Proxies\__CG__\CEOFESABundle\Entity\BParcours;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * BonCde controller
 *
 * @Route("/bon_commande")
 */
class BonCdeController extends Controller
{

    /**
     * Liste des bon de commandes
     *
     * @Route("/liste", name="bcd_index")
     * @Method("GET")
     * @Template("::BonCde\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        $bons = $em->getRepository('CEOFESABundle:BonCde')->findByStructure($id);

        return array(
            'bons' => $bons
        );
    }

    /**
     * Send bon de commande
     *
     * @Route("/send/{id}", name="bcd_send")
     * @Method("GET")
     */
    public function sendAction(Request $request, BonCde $bon)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        $bon->setBcdSent(true);

        $em->persist($bon);
        $em->flush();

        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }
}
