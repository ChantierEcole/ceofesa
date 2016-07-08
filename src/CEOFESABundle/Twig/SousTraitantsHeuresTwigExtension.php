<?php

namespace CEOFESABundle\Twig;

use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\Presence;
use CEOFESABundle\Entity\Structure;
use Doctrine\ORM\EntityManager;

/**
 * @author Florent Rosso <florent@widop.com>
 */
class SousTraitantsHeuresTwigExtension extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManager $doctrine)
    {
        $this->em = $doctrine;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('is_fully_billed', array($this, 'checkBill')),
            new \Twig_SimpleFunction('is_paid', array($this, 'checkPaid')),
        );
    }

    /**
     * @param \CEOFESABundle\Entity\DAF       $daf
     * @param \CEOFESABundle\Entity\Structure $structure
     *
     * @return bool
     */
    public function checkBill(DAF $daf, Structure $structure)
    {
         return  $this->em->getRepository(Presence::class)->checkBill($daf, $structure);
    }

    /**
     * @param \CEOFESABundle\Entity\DAF       $daf
     * @param \CEOFESABundle\Entity\Structure $structure
     *
     * @return bool
     */
    public function checkPaid(DAF $daf, Structure $structure)
    {
        return $this->em->getRepository(Presence::class)->checkPaid($daf, $structure);
    }

    /**
     * @return string
     */
    public function getName()
    {
       return "sous_traitants_extension";
    }
}
