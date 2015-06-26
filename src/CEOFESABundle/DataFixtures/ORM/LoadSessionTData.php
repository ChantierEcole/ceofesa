<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\SessionT;

class LoadSessionTData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $individuel = new SessionT();
        $individuel->setStyId(0);
        $individuel->setStyType('Individuel');

        $collectif = new SessionT();
        $collectif->setStyId(1);
        $collectif->setStyType('Collectif');

        $metadata = $manager->getClassMetaData(get_class(new SessionT()));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->persist($individuel);
        $manager->persist($collectif);

        $manager->flush();
    }
}