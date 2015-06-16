<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\FormationT;

class LoadFormationTData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $salle = new FormationT();
        $salle->setFtyId(0);
        $salle->setFtyType('SALLE');

        $prod = new FormationT();
        $prod->setFtyId(1);
        $prod->setFtyType('PRODUCTION');

        $metadata = $manager->getClassMetaData(get_class(new FormationT()));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->persist($salle);
        $manager->persist($prod);

        $manager->flush();
    }
}