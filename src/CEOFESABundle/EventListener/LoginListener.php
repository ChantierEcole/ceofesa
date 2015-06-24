<?php

namespace CEOFESABundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Custom login listener.
 * Listener qui se lance après login pour enregistrer les variables de session de l'utilisateur (structure et mail)
 */
class LoginListener
{
	/** @var \Symfony\Component\Security\Core\SecurityContext */
	private $securityContext;
	
	/** @var \Doctrine\ORM\EntityManager */
	private $em;
	
	/**
	 * Constructor
	 * 
	 * @param SecurityContext $securityContext
	 * @param Doctrine        $doctrine
	 */
	public function __construct(SecurityContextInterface $security, Session $session)
	{
		$this->security = $security;
      	$this->session = $session;
	}
	
	/**
	 * Do the magic.
	 * 
	 * @param InteractiveLoginEvent $event
	 */
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	{
		if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
			// user has just logged in
		}
		
		if ($this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			// user has logged in using remember_me cookie
		}
		
		$user = $event->getAuthenticationToken()->getUser();
		$structure = $user->getStructure()->getStrId();
		$mail = $user->getEmail();

		if (!empty($structure)) {
            $this->session->set('structure', $structure);
        }

        if (!empty($mail)) {
            $this->session->set('mail', $mail);
        }
	}
}
