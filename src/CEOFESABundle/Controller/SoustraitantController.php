<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Entity\Relation;
use Symfony\Component\HttpFoundation\Response;
use CEOFESABundle\Form\Type\RelationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CEOFESABundle\Entity\Structure;

/**
 * Structure controller.
 *
 * @Route("/soustraitant")
 */
class SoustraitantController extends Controller
{
    /**
     * Liste les Sous-Traitants de la Structure
     *
     * @Route("/liste", name="soustraitant_list")
     * @Method({"GET","POST"})
     *
     * @Template("::Soustraitant\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        $relations = $em->getRepository('CEOFESABundle:Relation')->findBy(array('relStructure' => $id));
        
        return array(
            'relations' => $relations,
        );
    }

    /**
     * Lier un Sous-Traitants à la Structure
     *
     * @Route("/add_relation", name="soustraitant_add_relation")
     * 
     * @Method({"GET","POST"})
     *
     * @Template("::Soustraitant\add_relation.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addRelationAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new RelationType());

        $form->handleRequest($request);
        if ($form->isValid()) {
            $relation = $form->getData();

            $structure = $em->getRepository('CEOFESABundle:Structure')->find($id);
            $relation->setRelStructure($structure);
            $relation->setRelOF($em->getRepository('CEOFESABundle:Structure')->getOfesa()->getQuery()->getOneOrNullResult());

            try {
                $em->persist($relation);
                $em->flush();
            } catch (\Exception $e) {

            }

            return $this->redirectToRoute('soustraitant_list');
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Print convention sous trainte
     *
     * @Route("/print_convention/{id}", name="soustraitant_convention_print")
     * @Method("GET")
     *
     * @param \CEOFESABundle\Entity\Relation $relation
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printConventionAction(Relation $relation)
    {
        $html = $this->renderView('::Templates\convention_soustraitance.html.twig', array(
            'relation' => $relation
        ));

        $response= new Response();
        $response->setContent($this->get('knp_snappy.pdf')->getOutputFromHtml($html,array('orientation' => 'Portrait','page-size' => 'A4')));
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename=convention-'.$relation->getRelSoustraitant()->getStrNom().'.pdf');

        return $response;
    }

    /**
     * Finds and displays a Structure entity.
     *
     * @Route("/{id}", name="soustraitant_show")
     * @Method("GET")
     *
     * @Template("::Soustraitant\show.html.twig")
     *
     * @param $id
     *
     * @return array
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Structure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Structure entity.');
        }

        return array('entity' => $entity);
    }

    /**
     * @param \CEOFESABundle\Entity\Relation            $relation
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @Route(
     *     path = "/edit/{id}",
     *     name = "soustraitant_edit"
     * )
     *
     * @Template("::Soustraitant\edit.html.twig")
     *
     *  * @return array
     */
    public function editAction(Relation $relation, Request $request)
    {
        $form = $this->createForm(new RelationType(), $relation);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($relation);
            $em->flush();

            return $this->redirect($this->generateUrl('soustraitant_list'));
        }

        return array('form' => $form->createView());
    }
}
