<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\Module;

class LoadModuleData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $m1 = new Module();
        $m1->setModId(1);
        $m1->setModCode('M1');
        $m1->setModIntitule('Compétences clés');
        $m1->setModIntituleLong('M1 – Développer des comportements nécessaires à la réussite du parcours - comprendre et communiquer par l’oral - lire, comprendre et communiquer par l’écrit - appréhender l’espace et le temps - utiliser les mathématiques en situation professionnelle');

        $m2 = new Module();
        $m2->setModId(2);
        $m2->setModCode('M2');
        $m2->setModIntitule('Information et communication');
        $m2->setModIntituleLong('M2 – Utiliser les techniques de l’information et de la communication');

        $m3 = new Module();
        $m3->setModId(3);
        $m3->setModCode('M3');
        $m3->setModIntitule('Santé Sécurité au travail');
        $m3->setModIntituleLong('M3 – Développer la sécurité au travail');

        $m4 = new Module();
        $m4->setModId(4);
        $m4->setModCode('M4');
        $m4->setModIntitule('Compétences professionnelles');
        $m4->setModIntituleLong('M4 – Mettre en œuvre des capacités professionnelles de base et réaliser des tâches professionnelles d’un métier');

        $metadata = $manager->getClassMetaData(get_class(new Module()));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->persist($m1);
        $manager->persist($m2);
        $manager->persist($m3);
        $manager->persist($m4);

        $manager->flush();
    }
}