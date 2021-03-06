<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\ModuleT;
use CEOFESABundle\Entity\Structure;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function getOFPrincipalAndSousTraitants($id)
    {
        $subQuery = $this->createQueryBuilder('f1')
            ->select('s1')
            ->innerJoin('f1.strRelations', 'r1')
            ->innerJoin('r1.relSoustraitant', 's1')
            ->andWhere('f1.strId = :id')
            ->getQuery()
            ->getDQL();

        return $this
            ->createQueryBuilder('f')
            ->orWhere('f.strType = 2')
            ->orWhere('f IN ('.$subQuery.')')
            ->orderBy('f.strNom','DESC')
            ->setParameter('id', $id);
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
     * @param array|string[] $structureType
     *
     * @return ArrayCollection|Structure[]
     */
    public function findByExternTypeStructures(array $structureType)
    {
        $qb = $this->createQueryBuilder('s');

        return $qb
            ->join('s.strType', 'strType')
            ->where($qb->expr()->in('strType.styType', $structureType))
            ->orderBy('s.strNom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
