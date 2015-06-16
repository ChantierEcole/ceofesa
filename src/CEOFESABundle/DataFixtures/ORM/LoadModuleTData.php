<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\ModuleT;

class LoadModuleTData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $intra = new ModuleT();
        $intra->setMtyId(0);
        $intra->setMtyType('INTRA');
        $intra->setMtyStructuretype($this->getReference('structure-type2'));

        $externe = new ModuleT();
        $externe->setMtyId(1);
        $externe->setMtyType('EXTERNE');
        $externe->setMtyStructuretype($this->getReference('structure-type3'));

        $metadata = $manager->getClassMetaData(get_class(new ModuleT()));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->persist($intra);
        $manager->persist($externe);

        $manager->flush();
    }

     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // l'ordre dans lequel les fichiers sont chargés
    }
}