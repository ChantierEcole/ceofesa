<?php

namespace CEOFESABundle\Controller;

use CEOFESABundle\Form\Type\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use CEOFESABundle\Form\Domain\utilisateur;
use CEOFESABundle\Form\Type\UtilisateurType;

/**
 * Admin controller.
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
	/**
    * @Route(
    * 	path="/users",
    * 	name="users_gestion"
    * )
    * @Method({"GET","POST"})
    */
    public function userGestionAction(Request $request)
    {
        // Pour récupérer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');

        // Pour récupérer la liste de tous les utilisateurs
        $users = $userManager->findUsers();
        
        return $this->render("User/gestion.html.twig",array('users'=>$users));
    }

	/**
	* Liste les devis en cours
    *
    * @Route(
    * 	path="/devis",
    * 	name="devis_gestion"
    * )
    */
    public function devisGestionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CEOFESABundle:Devis')->getDevisEnCours();

        return $this->render("Devis/admin.html.twig",array(
        	'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Devis entity for admin
     *
     * @Route("/devis/{id}", name="devis_admin_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CEOFESABundle:Devis')->find($id);
        $entities = $em->getRepository('CEOFESABundle:DParcours')->getParcoursDevis($id)->getQuery()->getResult();

        if (!$entity) {
            throw $this->createNotFoundException('Devis Introuvable. Désolé');
        }

        return $this->render("Devis/adminShow.html.twig",array(
            'entity'      => $entity,
            'entities' => $entities,
        ));
    }

    /**
	* Traitement ajax validation devis
    *
    * @Route(
    * 	path="/devis/valid",
    * 	name="devis_valid"
    * )
    * @Method("POST")
    */
    public function validAjaxAction(Request $request){

        $DevisId = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $devis = $em->getRepository('CEOFESABundle:Devis')->find($DevisId);
        $devstructure = $devis->getDevstructure();
        $mails = $em->getRepository('CEOFESABundle:Utilisateurs')->getMails($devstructure);

        if (!$devis) {
            throw $this->createNotFoundException(
                'Aucun devis trouvé pour cet id : '.$id
            );
        }

        $devis->setDevStatut('Validé');
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Votre devis a été validé')
            ->setFrom($this->container->getParameter('contact_mail1'))
            ->setTo($mails)
            ->setBody($this->renderView('Mail\validDevis.txt.twig',array('devis' => $devis)))
        ;
        $this->get('mailer')->send($message);

        return new Response($DevisId);
    }

    /**
    * Traitement ajax invalidation devis
    *
    * @Route(
    *   path="/devis/unvalid",
    *   name="devis_unvalid"
    * )
    * @Method("POST")
    */
    public function unvalidAjaxAction(Request $request){

        $DevisId = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();
        $devis = $em->getRepository('CEOFESABundle:Devis')->find($DevisId);

        if (!$devis) {
            throw $this->createNotFoundException(
                'Aucun devis trouvé pour cet id : '.$id
            );
        }

        $devis->setDevStatut('en cours');
        $em->flush();

        return new Response($DevisId);
    }

    /**
	* Traitement ajax refus devis
    *
    * @Route(
    * 	path="/devis/refuse",
    * 	name="devis_refuse"
    * )
    * @Method("POST")
    */
    public function refuseAjaxAction(Request $request){

        $DevisId = $request->request->get('id');
        $raison = $request->request->get('raison');

        $em = $this->getDoctrine()->getManager();
        $devis = $em->getRepository('CEOFESABundle:Devis')->find($DevisId);
        $devstructure = $devis->getDevstructure();
        $mails = $em->getRepository('CEOFESABundle:Utilisateurs')->getMails($devstructure);

        if (!$devis) {
            throw $this->createNotFoundException(
                'Aucun devis trouvé pour cet id : '.$id
            );
        }

        $devis->setDevStatut('Refusé');
        $em->flush();

        $message = \Swift_Message::newInstance()
            ->setSubject('Votre devis a été refusé')
            ->setFrom($this->container->getParameter('contact_mail1'))
            ->setTo($mails)
            ->setBody($this->renderView('Mail\refuseDevis.txt.twig',array('devis' => $devis,'raison' => $raison)))
        ;
        $this->get('mailer')->send($message);

        return new Response($DevisId); 

    }

    /**
    * Traitement ajax liste des structures admin menu header
    *
    * @Route(
    *   path="/structure/change",
    *   name="structure_change"
    * )
    */
    public function listAjaxAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('CEOFESABundle:Structure')->getStructures();

        $structures = $query->getQuery()->getResult();
        
        $StrList = array();

        foreach ($structures as $structure) {
            $p = array();
            $p['id'] = $structure->getStrId();
            $p['nom'] = $structure->getStrNom();
            $StrList[] = $p;
        }

        return new JsonResponse($StrList);
    }

    /**
    * Traitement ajax structure sélectionnée admin menu header
    *
    * @Route(
    *   path="/structure/session",
    *   name="structure_session"
    * )
    */
    public function sessionAjaxAction(Request $request){

        $idStructure = $this->get('session')->get('structure');
        $em = $this->getDoctrine()->getManager();
        $StrSession = $em->getRepository('CEOFESABundle:Structure')->find($idStructure);
        return new Response($StrSession);

    }

    /**
    * Traitement ajax changement de structure pour la session
    *
    * @Route(
    *   path="/change/session",
    *   name="change_session"
    * )
    */
    public function changeSessionAjaxAction(Request $request){

        $structureId = $request->request->get('structure_id');
        if (!empty($structureId)) {
            $this->get('session')->set('structure', $structureId);
        }

        return new Response($this->get('session')->get('structure'));

    }

    /**
     * Envoi d'emails aux utilisateurs
     *
     * @Route(
     *   path="/email",
     *   name="admin_email"
     * )
     */
    public function emailAction(Request $request){

        $form = $this->createForm(new EmailType());

        $form->handleRequest($request);
        if ($form->isValid()) {

            $data = $form->getData();

            foreach ($form->get('users')->getData() as $user) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($data['sujet'])
                    ->setFrom($this->container->getParameter('contact_mail1'))
                    ->setTo($user->getEmail())
                    ->setBody($data['message']);
                ;
                $this->get('mailer')->send($message);

            }

            $message = \Swift_Message::newInstance()
                ->setSubject($data['sujet'])
                ->setFrom($this->container->getParameter('contact_mail1'))
                ->setTo($this->getUser()->getEmail())
                ->setBody($data['message']);
            ;
            $this->get('mailer')->send($message);

            $this->addFlash('notice', 'E-mail envoyé.');

            return $this->redirectToRoute('admin_email');
        }

        return $this->render("User/email.html.twig", array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route(
     *       path="/admin/dashboard/general",
     *       name="general_dashboard"
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function generalDashboardAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $structure = $em->getRepository('CEOFESABundle:Structure')->find($id = $this->get('session')->get('structure'));
        $form = $this->createForm('dashboard_type');

        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $start = $data['start'];
            $end = $data['end'];

            if ($form->get('print')->isClicked()) {
                $response= new Response();
                $response->setContent($this->get('ceofesa.dashboard.exporter')->generalExportPdf($start, $end));
                $response->headers->set('Content-Type', 'application/pdf');
                $response->headers->set(
                    'Content-disposition',
                    'filename=Synthese-'.$start->format('d-m-Y').'-'.$end->format('d-m-Y').'.pdf'
                );

                return $response;
            }

            if ($form->has('export') && $form->get('export')->isClicked()) {
                $response= new Response();
                $response->setContent("\xEF\xBB\xBF".$this->get('ceofesa.dashboard.exporter')->exportCsv(null, $start, $end));
                $response->headers->set('Content-Type', 'application/csv');
                $response->headers->set(
                    'Content-disposition',
                    'filename=Synthese-'.$start->format('d-m-Y').'-'.$end->format('d-m-Y').'.csv'
                );

                return $response;
            }
        } else {
            $form->get('start')->setData($start = new \DateTime(date('Y-m-01 00:00:00')));
            $form->get('end')->setData($end = new \DateTime(date('Y-m-t 23:59:59')));
        }

        return $this->render("Main/structure_dashboard.html.twig", array(
            'participants' => $em->getRepository('CEOFESABundle:Parcours')->getParcoursByStructureAndDate(null, $start, $end),
            'structure'    => $structure,
            'form'         => $form->createView(),
        ));
    }
}
