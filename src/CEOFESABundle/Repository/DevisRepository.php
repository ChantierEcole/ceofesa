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
        // Sélection des numéros de devis qui apparaissent dans des parcours
        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select('IDENTITY(dp.dprDevis)')
            ->from('CEOFESABundle\Entity\Parcours', 'pr')
            ->join('pr.prcImpdevis', 'dp')
            ->groupBy('dp.dprDevis')
        ;

        // Sélection des devis qui ne sont pas parmis ceux de la requete précédente
        $qb = $this->createQueryBuilder('s');
        $qb ->where($qb->expr()->notIn('s.devId', $qb2->getDQL()))
            ->andWhere('s.devDatefin > :date')
            ->setParameter('date', new \DateTime())
        ;

        $query  = $qb->getQuery();
        return $query->getResult();

    }

    public function getStructureDevis($id_devis){
        $qb = $this->createQueryBuilder('s');
        $qb->select('IDENTITY(s.devStructure)')
        ->where('s.devId = :id')
        ->setParameter('id', $id_devis)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
