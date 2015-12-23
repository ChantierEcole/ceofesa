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
     * Send bon de commande
     *
     * @Route("/send/{id}", name="bcd_send")
     * @Method("GET")
     */
    public function sendAction(BonCde $bon)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        $bon->setBcdSent(true);

        $em->persist($bon);
        $em->flush();

        return $this->redirect($this->generateUrl('daf_show', array('id' => $bon->getBcdDaf()->getDafId())));
    }
}
