<?php

//// Surchage du RegistrationController de FOSUserBundle ////////////////
//// pour désactiver le log automatique après inscription ///////////////
//// + Ajout formulaire de demande d'inscription ////////////////////////

namespace CEOFESABundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use CEOFESABundle\Form\Domain\utilisateur;
use CEOFESABundle\Form\Type\UtilisateurType;


class RegistrationController extends BaseController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return null|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            // log automatique à l'inscription (désactivé si commenté)
            // $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render(
            'FOSUserBundle:Registration:register.html.twig', 
            array('form' => $form->createView())
        );
    }

    /**
    * @Route(
    *       path = "/login/new",
    *       name = "login_new"
    * )
     * 
    * @Method({"GET","POST"})
    */
    public function loginNewAction(Request $request)
    {
        $utilisateur = new utilisateur();
        $form = $this->createForm(new UtilisateurType(),$utilisateur);
        $form -> handleRequest($request);

        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Demande de compte')
                ->setFrom($this->container->getParameter('contact_mail1'))
                ->setTo(array(
                    $this->container->getParameter('contact_mail1'),
                    $this->container->getParameter('contact_mail2')
                ))
                ->setBody($this->renderView('Mail\utilisateur.txt.twig',array('utilisateur' => $utilisateur)))
            ;
            $this->get('mailer')->send($message);

            return $this->render('FOSUserBundle:Registration:request_confirmed.html.twig');
        }

        return $this->render("User/loginnew.html.twig",array('form' => $form->createView()));
    }
}
