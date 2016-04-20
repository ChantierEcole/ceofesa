<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\Tiers;
use Doctrine\ORM\EntityRepository;

class PresenceRepository extends EntityRepository
{
	public function getPresencesSession($id)
    {
        return $this
            ->createQueryBuilder('p')
            ->where('p.pscSession = :SessionId')
            ->setParameter('SessionId', $id);
    }

    /**
     * @param $idsession
     * @param Tiers $tiers
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getPresence($idsession, Tiers $tiers)
    {
        return $this
        ->createQueryBuilder('p')
        ->join('p.pscParcours', 'prc')
        ->join('prc.prcDcont', 'cnt')
        ->where('p.pscSession = :SessionId')
        ->andWhere('cnt.cntTiers = :tiers')
        ->setParameters(array('SessionId' => $idsession, 'tiers' => $tiers))
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

    /**
     * @param $parcours
     * @return mixed
     */
    public function getParcoursTotalDurees($parcours)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('sum(t.pscDuree as total')
            ->where('t.pscParcours = :parcours')
            ->setParameter('parcours', $parcours)
        ;
        $result = $qb->getQuery()->getSingleScalarResult();
        return $result;
    }

    public function getParcoursDcontTotalDurees($dcont,$mtype,$module,$structure)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('sum(t.pscDuree as total')
        ->innerJoin('t.pscParcours','par')
        ->where('par.prcDcont = :dcont')
        ->andWhere('par.prcType = :mtype')
        ->andWhere('par.prcModule = :module')
        ->andWhere('par.prcStructure = :structure')
        ->setParameters(array('dcont'=> $dcont,'mtype' => $mtype,'module' => $module,'structure' => $structure))
        ;
        $result = $qb->getQuery()->getSingleScalarResult();
        return $result;
    }

    public function getPresencesParcours($idparcours)
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.pscParcours = :idparcours')
        ->setParameter('idparcours', $idparcours)
        ;
    }
}
