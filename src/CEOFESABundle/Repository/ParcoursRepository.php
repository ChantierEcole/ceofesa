<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class ParcoursRepository extends EntityRepository
{
	public function getParcours($idStructure,$idOF,$idModule,$idModuleType)
    {
        return $this
        ->createQueryBuilder('par')
        ->innerJoin('par.prcDcont','dcnt')
        ->innerJoin('dcnt.cntDaf','daf')
        ->where('par.prcStructure = :IdOF')
        ->andWhere('par.prcModule = :IdModule')
        ->andWhere('par.prcType = :IdModuleType')
        ->andWhere('daf.dafStructure = :IdStructure')
        ->setParameters(array('IdStructure' => $idStructure, 'IdOF' => $idOF, 'IdModule' => $idModule, 'IdModuleType' => $idModuleType))
        ;
    }

    public function getDcontTotalHeures($dcont)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('sum(t.prcNombreheure as total')
        ->where('t.prcDcont = :dcont')
        ->setParameter('dcont', $dcont)
        ;
        $result = $qb->getQuery()->getSingleScalarResult();
        return $result;
    }
}