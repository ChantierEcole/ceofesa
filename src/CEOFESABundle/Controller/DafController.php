<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\DCont;
use CEOFESABundle\Entity\Devis;
use CEOFESABundle\Form\Type\DafType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Devis controller
 *
 * @Route("/daf")
 */
class DafController extends Controller
{
    /**
     * Liste des daf
     *
     * @Route("/", name="daf")
     * @Method("GET")
     * @Template("::Daf\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        $entities = $em->getRepository('CEOFESABundle:DAF')->findBy(array('dafStructure' => $id), array('dafDatedebut' => 'ASC'));

        return array(
            'dafs' => $entities,
        );
    }


    /**
     * Creation d'une daf
     *
     * @Route("/new/{id}", name="new_daf")
     * @Template("::Daf\new.html.twig")
     */
    public function newAction(Request $request, Devis $devis)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em     = $this->getDoctrine()->getManager();
        $form   = $this->createCreateForm($devis);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $daf = $form->getData();

            /* DEFAULT SORTIE TYPE */
            $sortieT = $em->getRepository('CEOFESABundle:SortieT')->find(DCont::DEFAULT_SORTIE_ID);
            foreach ($daf->getDafDcont() as $dCont) {
                $dCont->setCntMotifsortie($sortieT);
            }

            $daf->setDafNbsalarie($daf->calcNbSalarie());
            $daf->setDafNbheure($daf->calcNbheure());
            $daf->setDafMontant($daf->calcMontant());

            $em->persist($daf);
            $em->flush();

            return $this->redirectToRoute('daf');
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Formulaire pour la création d'une entité Daf à partir d'un devis
     *
     * @param Devis $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Devis $entity)
    {
        $id = $this->get('session')->get('structure');

        $daf = new DAF();
        $daf->createFromDevis($entity);

        $form = $this->createForm(new DafType($id), $daf, array(
            'action' => $this->generateUrl('new_daf', array('id' => $entity->getDevId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Affiche les détails d'une entité DAF
     *
     * @Route("/{id}", name="daf_show")
     * @Method("GET")
     * @Template("::Daf\show.html.twig")
     */
    public function showAction(DAF $daf)
    {
        return array(
            'daf'   => $daf
        );
    }
}
