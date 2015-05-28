<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class DParcoursRepository extends EntityRepository
{
    public function getParcoursDevis($id_devis){
        return $this
        ->createQueryBuilder('d')
        ->where('d.dprDevis = :idDevis')
        ->setParameter('idDevis',$id_devis)
        ;
    }

    public function getStagiairesDevis($id_devis){
    	return $this->createQueryBuilder('n')
        ->where('n.dprDevis = :idDevis')
        ->groupBy('n.dprNumero')
        ->orderBy('n.dprNumero','ASC')
        ->setParameter('idDevis', $id_devis)
        ;
    }
}
