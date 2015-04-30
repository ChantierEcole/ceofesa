<?php

namespace CEOFESABundle\Controller;

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
