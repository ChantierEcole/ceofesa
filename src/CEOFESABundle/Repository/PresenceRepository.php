<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class PresenceRepository extends EntityRepository
{
	public function getPresencesSession($id)
    {
        return $this
        ->createQueryBuilder('p')
        ->where('p.pscSession = :SessionId')
        ->setParameter('SessionId',$id)
        ;
    }

    public function getPresence($idsession,$idparcours)
    {
        return $this
        ->createQueryBuilder('p')
        ->where('p.pscSession = :SessionId')
        ->andWhere('p.pscParcours = :ParcoursId')
        ->setParameters(array('SessionId' => $idsession, 'ParcoursId' => $idparcours))
        ;
    }

    public function getDcontTotalDurees($dcont)
    {
    	$qb = $this->createQueryBuilder('t');
    	$qb->select('sum(t.pscDuree as total')
    	->innerJoin('t.pscParcours','par')
        ->where('par.prcDcont = :dcont')
        ->setParameter('dcont', $dcont)
        ;
        $result = $qb->getQuery()->getSingleScalarResult();
        return $result;
    }
}