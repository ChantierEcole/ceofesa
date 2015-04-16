<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class DParcoursRepository extends EntityRepository
{
    public function getParcoursDevis($id_devis){
        return $this
        ->createQueryBuilder('d')
        ->where('d.dprDevis = :DevisId')
        ->setParameter('DevisId',$id_devis)
        ;
    }
}
