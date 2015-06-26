<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\StructureT;

class LoadStructureTData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $structure = new StructureT();
        $structure->setStyId(1);
        $structure->setStyType('Structure');

        $ofprincipal = new StructureT();
        $ofprincipal->setStyId(2);
        $ofprincipal->setStyType('OF Principal');

        $soustraitant = new StructureT();
        $soustraitant->setStyId(3);
        $soustraitant->setStyType('OF Sous-traitant');

        $metadata = $manager->getClassMetaData(get_class(new StructureT()));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->persist($structure);
        $manager->persist($ofprincipal);
        $manager->persist($soustraitant);

        $manager->flush();

        $this->addReference('structure-type1', $structure);
        $this->addReference('structure-type2', $ofprincipal);
        $this->addReference('structure-type3', $soustraitant);
    }

     /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // l'ordre dans lequel les fichiers sont chargés
    }
}