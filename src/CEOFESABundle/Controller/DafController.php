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

        $entities = $em->getRepository('CEOFESABundle:DAF')->getDafByStructure($id);

        return array(
            'dafs' => $entities,
        );
    }


    /**
     * Creation d'une daf
     *
     * @Route("/new/{id}", defaults={"id" = null}, name="new_daf")
     * @Template("::Daf\new.html.twig")
     */
    public function newAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $idStructure = $this->get('session')->get('structure');

        $devis = $id !== null ? $em->getRepository('CEOFESABundle:Devis')->find($id) : new Devis();
        $form = $this->createCreateForm($devis);

        if ($form->handleRequest($request)->isValid()) {
            $daf = $form->getData();

            $sortieT = $em->getRepository('CEOFESABundle:SortieT')->find(DCont::DEFAULT_SORTIE_ID);
            foreach ($daf->getDafDcont() as $dCont) {
                $dCont->setCntMotifsortie($sortieT);
            }

            $daf->setDafStructure($em->getReference('CEOFESABundle\Entity\Structure', $idStructure));
            $daf->setDafOF($em->getRepository('CEOFESABundle:Structure')->getOfesa()->getQuery()->getOneOrNullResult());
            $daf->setDafNbsalarie($daf->calcNbSalarie());
            $daf->setDafNbheure($daf->calcNbheure());
            $daf->setDafMontant($daf->calcMontant());

            $em->persist($daf);
            $em->flush();

            $this->manageBonCommande($daf);

            return $this->redirectToRoute('daf');
        }

        return array('form' => $form->createView());
    }

    /**
     * Edition d'une daf
     *
     * @Route("/edit/{id}", name="edit_daf")
     * @Template("::Daf\new.html.twig")
     */
    public function editAction(Request $request, DAF $daf)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new DafType(), $daf, array(
            'structure' => $id,
            'action'    => $this->generateUrl('edit_daf', array('id' => $daf->getDafId())),
            'method'    => 'POST',
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $sortieT = $em->getRepository('CEOFESABundle:SortieT')->find(DCont::DEFAULT_SORTIE_ID);
            foreach ($daf->getDafDcont() as $dCont) {
                if ($dCont->getCntMotifsortie() === null) {
                    $dCont->setCntMotifsortie($sortieT);
                }
            }

            $em->persist($daf);
            $em->flush();

            return $this->redirectToRoute('daf');
        }

        return [
            'form'  => $form->createView()
        ];
    }

    /**
     * @param DAF $daf
     */
    private function manageBonCommande(DAF $daf) {

        $em             = $this->getDoctrine()->getManager();
        $sousTraitants  = $em->getRepository('CEOFESABundle:Structure')->findDAFSousTraitants($daf->getDafId());

        foreach ($sousTraitants as $ss) {
            $bcd = new BonCde();

            $relation = $em->getRepository('CEOFESABundle:Relation')->getRelation($daf->getDafStructure()->getStrId(), $ss->getStrId(), $daf->getDafOf()->getStrId())->getQuery()->getOneOrNullResult();
            $year     = $daf->getDafDatedebut()->format('Y');

            $bcd->setBcdAnnee($year);
            $bcd->setBcdDate($daf->getDafDatedebut());
            $bcd->setBcdRelation($relation);
            $bcd->setBcdNumero($em->getRepository('CEOFESABundle:BonCde')->getBcdNumber($year, $relation));
            $bcd->setBcdDAF($daf);
            $bcd->setBcdSent(false);

            foreach ($daf->getDafDcont() as $dCont) {
                foreach ($dCont->getCntParcours() as $parcours) {
                    if ($parcours->getPrcType()->getMtyType() == ModuleT::EXTER && $parcours->getPrcStructure()->getStrId() == $ss->getStrId()) {
                        $bparcours = new BParcours();
                        $bparcours->setBprNombreheure($parcours->getPrcNombreheure());
                        $bparcours->setBprTauxhoraire($daf->getDafTauxhoraire() === 9.15 ? 8.15 : (float)10);
                        $bparcours->setBprParcours($parcours);
                        $bparcours->setBprBonCde($bcd);
                        $bcd->addBcdBParcour($bparcours);
                        $em->persist($bcd);
                    }
                }
            }

            $em->persist($bcd);
            $em->flush();
        }


        return ;
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

        $form = $this->createForm(new DafType(), $daf, array(
            'structure' => $id,
            'action'    => $this->generateUrl('new_daf', array('id' => $entity->getDevId())),
            'method'    => 'POST',
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
        $em = $this->getDoctrine()->getManager();

        $bonCdes = $em->getRepository('CEOFESABundle:BonCde')->findBy(array('bcdDAF' => $daf));

        return array(
            'bonCdes' => $bonCdes,
            'daf'     => $daf
        );
    }

    /**
     * Imprimer le bon de commande d'un sous traitant de la DAF
     *
     * @Route("/print_bon_commande/{id}", name="print_st_daf")
     * @Method("GET")
     */
    public function printBonCommandeAction(BonCde $bonCde)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $html = $this->renderView('::Templates\bon_commande.html.twig', array(
            'bonCde' => $bonCde,
        ));

        $response= new Response();
        $response->setContent($this->get('knp_snappy.pdf')->getOutputFromHtml($html,array('orientation' => 'Portrait','page-size' => 'A4')));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename=bon_commande-'.$bonCde->getBcdRelation()->getRelSoustraitant()->getStrNom().'.pdf');

        return $response;
    }


}
