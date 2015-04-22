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

    public function getDevisEnCours(){
        /*$qb = $this->createQueryBuilder('n');
        return $this
        -> createQueryBuilder('c')
        -> leftjoin('c.devID','dp')
        ;*/


        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select('IDENTITY(dp.dprDevis)')
            ->from('CEOFESABundle\Entity\Parcours', 'pr')
            ->join('pr.prcImpdevis', 'dp')
            ->groupBy('dp.dprDevis')
        ;

        /*return $qb2
        ->getQuery()
        ->getArrayResult()
        ;*/

        $qb = $this->createQueryBuilder('s');
        $qb ->where($qb->expr()->notIn('s.devId', $qb2->getDQL()));

        $query  = $qb->getQuery();
        return $query->getResult();


/*
        $qb  = $this->_em->createQueryBuilder();
        $qb->select('mm')
            ->from('Custom\Entity\Membre', 'mm')
            ->where($qb->expr()->notIn('mm.id', $qb2->getDQL())
        );
        $qb->setParameter(1, $service);
        $query  = $qb->getQuery();

        return $query->getResult();*/
    }
}
