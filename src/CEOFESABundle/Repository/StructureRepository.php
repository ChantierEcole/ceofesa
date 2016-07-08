<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\ModuleT;
use CEOFESABundle\Entity\Structure;
use Doctrine\ORM\EntityRepository;

class StructureRepository extends EntityRepository
{

    public function getStructure($id)
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.strId = :ofId')
        ->setParameter('ofId',$id)
        ;
    }

    public function getUserStructure($id)
    {
        return $this
        ->createQueryBuilder('u')
        ->where('u.strId = :userStructureId')
        ->setParameter('userStructureId',$id)
        ->orderBy('u.strNom','ASC')
        ;
    }

    public function getOfesa()
    {
        return $this
        ->createQueryBuilder('o')
        ->where('o.strId = 2')
        ;
    }

    public function getOFPrincipal()
    {
        return $this
            ->createQueryBuilder('f')
            ->where('f.strType = 2')
            ->orderBy('f.strNom','DESC')
            ;
    }

    public function getOF()
    {
        return $this
        ->createQueryBuilder('f')
        ->where('f.strType = 2 OR f.strType = 3')
        ->orderBy('f.strNom','ASC')
        ;
    }

    public function getStructures()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.strType = 1')
        ->orderBy('s.strNom','ASC')
        ;
    }

    public function getSoustraitants($id)
    {
        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select('IDENTITY(rl.relSoustraitant)')
            ->from('CEOFESABundle\Entity\Relation', 'rl')
            ->where('rl.relStructure = :id')
        ;

        $qb = $this->createQueryBuilder('st');
        $qb ->where('st.strType = 3')
            ->andWhere($qb->expr()->in('st.strId', $qb2->getDQL()))
            ->setParameter('id', $id)
            ->orderBy('st.strNom','ASC')
        ;

        return $qb;
    }

    public function getIntra()
    {
        return $this
            ->createQueryBuilder('s')
            ->where('s.strId = :id')
            ->setParameter('id', Structure::OFESA_ID)
        ;
    }

    public function getSoustraitant($id)
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.strId = :ofId')
        ->setParameter('ofId',$id)
        ->orderBy('s.strNom','ASC')
        ;
    }

    public function findDAFSousTraitants($dafId)
    {
        $qb = $this
            ->createQueryBuilder('s')
            ->join('s.strParcours', 'prc')
            ->join('prc.prcType', 'mty')
            ->join('prc.prcDcont', 'cnt')
            ->where('cnt.cntDaf = :dafId')
            ->andWhere('mty.mtyType = :externType')
            ->setParameter('dafId', $dafId)
            ->setParameter('externType', ModuleT::EXTER)
            ->orderBy('s.strNom','ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function getAllStructures()
    {
        return $this
        ->createQueryBuilder('s')
        ->orderBy('s.strNom','ASC')
        ;
    }

    /**
     * @param \CEOFESABundle\Entity\DAF $daf
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getSousTraitantsNbHeures(DAF $daf)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('s as structure, SUM(prc.prcNombreheure) as nbHeures')
            ->leftJoin('s.strParcours', 'prc')
            ->leftJoin('prc.prcDcont', 'dc')
            ->leftJoin('dc.cntDaf', 'daf')
            ->leftJoin('prc.prcType', 'm')
            ->andWhere('daf.dafId = :dafId')
            ->andWhere('m.mtyType = :type')
            ->distinct('dc')
            ->groupBy('s.strId, dc')
            ->setParameter('dafId', $daf)
            ->setParameter('type', 'EXTERNE')
            ;
    }
}
