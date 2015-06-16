<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\CiviliteT;

class LoadCiviliteTData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $monsieur = new CiviliteT();
        $monsieur->setCtyId(0);
        $monsieur->setCtyType('Monsieur');
        $monsieur->setCtyTypecourt('Mr');

        $madame = new CiviliteT();
        $madame->setCtyId(1);
        $madame->setCtyType('Madame');
        $madame->setCtyTypecourt('Mme');

        $manager->persist($monsieur);
        $manager->persist($madame);

        $manager->flush();
    }
}