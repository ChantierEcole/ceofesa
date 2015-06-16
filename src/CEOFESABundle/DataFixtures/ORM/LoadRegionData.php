<?php 

namespace CEOFESABundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CEOFESABundle\Entity\Region;

class LoadRegionData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $als = new Region();
        $als->setRegId('ALS');
        $als->setRegNom('Alsace');

        $aq = new Region();
        $aq->setRegId('AQ');
        $aq->setRegNom('Aquitaine');

        $auv = new Region();
        $auv->setRegId('AUV');
        $auv->setRegNom('Auvergne');

        $bn = new Region();
        $bn->setRegId('BN');
        $bn->setRegNom('Basse-Normandie');

        $bo = new Region();
        $bo->setRegId('BO');
        $bo->setRegNom('Bourgogne');

        $bre = new Region();
        $bre->setRegId('BRE');
        $bre->setRegNom('Bretagne');

        $ce = new Region();
        $ce->setRegId('CE');
        $ce->setRegNom('Centre');

        $ca = new Region();
        $ca->setRegId('CA');
        $ca->setRegNom('Champagne-Ardennes');

        $co = new Region();
        $co->setRegId('CO');
        $co->setRegNom('Corse');

        $fc = new Region();
        $fc->setRegId('FC');
        $fc->setRegNom('Franche Comté');

        $hn = new Region();
        $hn->setRegId('HN');
        $hn->setRegNom('Haute-Normandie');

        $idf = new Region();
        $idf->setRegId('IDF');
        $idf->setRegNom('Ile-de-France');

        $lr = new Region();
        $lr->setRegId('LR');
        $lr->setRegNom('Languedoc-Roussillon');

        $lim = new Region();
        $lim->setRegId('LIM');
        $lim->setRegNom('Limousin');

        $lo = new Region();
        $lo->setRegId('LO');
        $lo->setRegNom('Lorraine');

        $mp = new Region();
        $mp->setRegId('MP');
        $mp->setRegNom('Midi-Pyrénées');

        $npdc = new Region();
        $npdc->setRegId('NPDC');
        $npdc->setRegNom('Nord-Pas de Calais');

        $pdl = new Region();
        $pdl->setRegId('PDL');
        $pdl->setRegNom('Pays de la Loire');

        $pic = new Region();
        $pic->setRegId('PIC');
        $pic->setRegNom('Picardie');

        $pc = new Region();
        $pc->setRegId('PC');
        $pc->setRegNom('Poitou-Charentes');

        $paca = new Region();
        $paca->setRegId('PACA');
        $paca->setRegNom("Provence-Alpes-Côtes d'Azur");

        $ra = new Region();
        $ra->setRegId('RA');
        $ra->setRegNom('Rhône-Alpes');


        $manager->persist($als);
        $manager->persist($aq);
        $manager->persist($auv);
        $manager->persist($bn);
        $manager->persist($bo);
        $manager->persist($bre);
        $manager->persist($ce);
        $manager->persist($ca);
        $manager->persist($co);
        $manager->persist($fc);
        $manager->persist($hn);
        $manager->persist($idf);
        $manager->persist($lr);
        $manager->persist($lim);
        $manager->persist($lo);
        $manager->persist($mp);
        $manager->persist($npdc);
        $manager->persist($pdl);
        $manager->persist($pic);
        $manager->persist($pc);
        $manager->persist($paca);
        $manager->persist($ra);

        $manager->flush();
    }
}