<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\SortieT;

class LoadSortieTData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $aucun = new SortieT();
        $aucun->setSrtId(0);
        $aucun->setSrtMotif('Aucun');

        $abandon1 = new SortieT();
        $abandon1->setSrtId(1);
        $abandon1->setSrtMotif('abandon formation - refus formation');

        $abandon2 = new SortieT();
        $abandon2->setSrtId(2);
        $abandon2->setSrtMotif('abandon formation - réorientation vers qualification');

        $abandon3 = new SortieT();
        $abandon3->setSrtId(3);
        $abandon3->setSrtMotif('abandon contrat de travail - raison santé social');

        $abandon4 = new SortieT();
        $abandon4->setSrtId(4);
        $abandon4->setSrtMotif('abandon contrat de travail - autre raison');

        $fin = new SortieT();
        $fin->setSrtId(5);
        $fin->setSrtMotif('fin de contrat');

        $poursuite1 = new SortieT();
        $poursuite1->setSrtId(6);
        $poursuite1->setSrtMotif('poursuite du parcours - formation qualifiante');

        $poursuite2 = new SortieT();
        $poursuite2->setSrtId(7);
        $poursuite2->setSrtMotif('poursuite du parcours - formation préqualifiante');

        $poursuite3 = new SortieT();
        $poursuite3->setSrtId(8);
        $poursuite3->setSrtMotif('poursuite du parcours - formation comp clés');

        $poursuite4 = new SortieT();
        $poursuite4->setSrtId(9);
        $poursuite4->setSrtMotif('poursuite du parcours - contrat professionnalisation');

        $poursuite5 = new SortieT();
        $poursuite5->setSrtId(10);
        $poursuite5->setSrtMotif('poursuite du parcours - CDD < 6mois');

        $poursuite6 = new SortieT();
        $poursuite6->setSrtId(11);
        $poursuite6->setSrtMotif('poursuite du parcours - CDD > 6 mois');

        $poursuite7 = new SortieT();
        $poursuite7->setSrtId(12);
        $poursuite7->setSrtMotif('poursuite du parcours - CDI');

        $metadata = $manager->getClassMetaData(get_class(new SortieT()));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->persist($aucun);
        $manager->persist($abandon1);
        $manager->persist($abandon2);
        $manager->persist($abandon3);
        $manager->persist($abandon4);
        $manager->persist($fin);
        $manager->persist($poursuite1);
        $manager->persist($poursuite2);
        $manager->persist($poursuite3);
        $manager->persist($poursuite4);
        $manager->persist($poursuite5);
        $manager->persist($poursuite6);
        $manager->persist($poursuite7);

        $manager->flush();
    }
}