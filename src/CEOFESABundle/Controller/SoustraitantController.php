<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Form\Type\RelationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CEOFESABundle\Entity\Structure;
use CEOFESABundle\Form\Type\SoustraitantType;

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
     * @Template("::Soustraitant\index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        $entities = $em->getRepository('CEOFESABundle:Structure')->getSoustraitants($id)->getQuery()->getResult();
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lier un Sous-Traitants à la Structure
     *
     * @Route("/add_relation", name="soustraitant_add_relation")
     * @Method({"GET","POST"})
     * @Template("::Soustraitant\add_relation.html.twig")
     */
    public function addRelationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->get('session')->get('structure');

        $form = $this->createForm(new RelationType());

        $form->handleRequest($request);
        if ($form->isValid()) {
            $relation = $form->getData();

            $structure = $em->getRepository('CEOFESABundle:Structure')->find($id);
            $relation->setRelStructure($structure);

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
     * Finds and displays a Structure entity.
     *
     * @Route("/{id}", name="soustraitant_show")
     * @Method("GET")
     * @Template("::Soustraitant\show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Structure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Structure entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
