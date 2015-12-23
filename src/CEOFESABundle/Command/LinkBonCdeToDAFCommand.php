<?php

namespace CEOFESABundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DafController
 * @package CEOFESABundle\Command
 */
class LinkBonCdeToDAFCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ceofesa:link:bontodaf')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();

        $BonCdes  = $em->getRepository('CEOFESABundle:BonCde')->findBy(array('bcdDAF' => null));

        foreach ($BonCdes as $bon) {

            $bparcours = $bon->getBcdBParcours()->first();

            if ($bparcours && $bparcours->getBprParcours()) {
                $daf = $bparcours->getBprParcours()->getPrcDcont()->getCntDAF();
                $bon->setBcdDAF($daf);

                $em->persist($bon);
                $em->flush();

                $output->writeln("[INFO] La DAF  ". $daf->getDafDossier() . " a été lié au bon de commande " . $bon->getBcdId());
            } else {
                $output->writeln("[ERROR] Pas de DAF  pour le bon de commande " . $bon->getBcdId());
            }
        }
    }
}
