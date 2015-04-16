<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class DevisRepository extends EntityRepository
{
    public function getNextNum(){
        $annee = date("Y");

        $qb = $this->createQueryBuilder('n');
        $qb->select('n.devNumero')
        ->where('n.devAnnee = :annee')
        ->orderBy('n.devNumero','DESC')
        ->setMaxResults(1)
        ->setParameter('annee', $annee)
        ;   

        $result = $qb->getQuery()->getSingleScalarResult();

        $result += 1;
        if($result<100){
            $result = '0'.$result;
        }

        return $result;
    }

    public function getDevisStructure($id_structure){
        return $this
        ->createQueryBuilder('s')
        ->where('s.devStructure = :StructureId')
        ->setParameter('StructureId',$id_structure)
        ;
    }
}
