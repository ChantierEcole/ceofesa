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

    public function getParcoursAndSessions($idStructure, $idOF, $idModule, $idModuleType, $date)
    {
        $qb = $this->getParcours($idStructure, $idOF, $idModule, $idModuleType);

        $qb->addSelect('pre', 'ses')
            ->innerJoin('par.prcPresence', 'pre')
            ->innerJoin('pre.pscSession', 'ses')
            ->andWhere('ses.sesDate >= :dateMin')
            ->andWhere('ses.sesDate <= :dateMax')
            ->setParameter('dateMin', new \DateTime($date->format('Y-m-01')))
            ->setParameter('dateMax', new \DateTime($date->format('Y-m-t')))
            ->orderBy('ses.sesDate', 'ASC');

        return $qb->getQuery()->getResult();
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