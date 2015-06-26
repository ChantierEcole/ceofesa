<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\TiersT;

class LoadTiersTData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cstructure = new TiersT();
        $cstructure->setTtyId(1);
        $cstructure->setTtyType('Contact Structure');

        $cof = new TiersT();
        $cof->setTtyId(2);
        $cof->setTtyType('Contact OF');

        $salpoly = new TiersT();
        $salpoly->setTtyId(3);
        $salpoly->setTtyType('Salarié Polyvalent');

        $salperm = new TiersT();
        $salperm->setTtyId(4);
        $salperm->setTtyType('Salarié Permanent');

        $formateurof = new TiersT();
        $formateurof->setTtyId(5);
        $formateurof->setTtyType('Formateur OF');

        $metadata = $manager->getClassMetaData(get_class(new TiersT()));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->persist($cstructure);
        $manager->persist($cof);
        $manager->persist($salpoly);
        $manager->persist($salperm);
        $manager->persist($formateurof);

        $manager->flush();
    }
}