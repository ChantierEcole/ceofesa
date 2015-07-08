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

        return $result;
    }

    public function getDevisStructure($id_structure){
        return $this
        ->createQueryBuilder('s')
        ->where('s.devStructure = :StructureId')
        ->setParameter('StructureId',$id_structure)
        ;
    }

    // Affiche les devis non-intégrés dans des parcours modifiés dans les deux derniers mois
    public function getDevisEnCours(){
        // Sélection des numéros de devis qui apparaissent dans des parcours
        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select('IDENTITY(dp.dprDevis)')
            ->from('CEOFESABundle\Entity\Parcours', 'pr')
            ->join('pr.prcImpdevis', 'dp')
            ->groupBy('dp.dprDevis')
        ;

        // Date d'aujourd'hui moins 2 mois
        $time = date("Y-m-d", strtotime("-2 month"));

        // Sélection des devis qui ne sont pas parmis ceux de la requete précédente
        $qb = $this->createQueryBuilder('s');
        $qb ->where($qb->expr()->notIn('s.devId', $qb2->getDQL()))
            ->andWhere('s.devDatedevis > :date')
            ->setParameter('date', $time)
            ->orderBy('s.devDatedevis','DESC')
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

    public function getStatutDevis($id_devis){
        $qb = $this->createQueryBuilder('s');
        $qb->select('s.devStatut')
        ->where('s.devId = :id')
        ->setParameter('id', $id_devis)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
