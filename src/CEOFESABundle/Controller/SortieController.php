<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Entity\BonCde;
use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\DCont;
use CEOFESABundle\Entity\Devis;
use CEOFESABundle\Entity\ModuleT;
use CEOFESABundle\Entity\Structure;
use CEOFESABundle\Form\Type\DafType;
use CEOFESABundle\Form\Type\DContType;
use CEOFESABundle\Form\Type\SortieType;
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
 * Sortie controller
 *
 * @Route("/daf/sortie")
 */
class SortieController extends Controller
{
    /**
     * Edit motif sortie
     *
     * @Route("/edit/{id}", name="sortie_edit")
     * @Template("::Sortie\edit.html.twig")
     */
    public function editAction(Request $request, DCont $DCont)
    {
        $form = $this->createForm(new SortieType(), $DCont);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($DCont);
            $em->flush();

            return $this->redirectToRoute('daf_show', array('id' => $DCont->getCntDaf()->getDafId()));
        }

        return array(
            'form' => $form->createView(),
        );
    }


}
