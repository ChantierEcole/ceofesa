<?php

namespace CEOFESABundle\Twig;

use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\Presence;
use CEOFESABundle\Entity\Structure;
use Doctrine\ORM\EntityManager;

class SousTraitantsHeuresTwigExtension extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManager $doctrine)
    {
        $this->em = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('verif_facture', array($this, 'checkBill')),
            new \Twig_SimpleFunction('verif_payee', array($this, 'checkPaid')),
        );
    }

    public function checkBill(DAF $daf, Structure $structure)
    {
         return  $this->em->getRepository(Presence::class)->checkBill($daf, $structure);
    }

    public function checkPaid(DAF $daf, Structure $structure)
    {
        return $this->em->getRepository(Presence::class)->checkPaid($daf, $structure);
    }

    public function getName()
    {
       return "sous_traitants_extension";
    }
}
