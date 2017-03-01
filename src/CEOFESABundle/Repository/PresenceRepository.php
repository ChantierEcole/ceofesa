<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\DCont;
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

    /**
     * @param DCont $dcont
     *
     * @return int
     */
    public function getDcontTotalDurees($dcont)
    {
    	return $this->createQueryBuilder('t')
    	    ->select('sum(t.pscDuree) as total')
            ->innerJoin('t.pscParcours','par')
            ->where('par.prcDcont = :dcont')
            ->setParameter('dcont', $dcont)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param DAF $daf
     *
     * @return int
     */
    public function getDafTotalDurees(DAF $daf)
    {
        return $this->createQueryBuilder('t')
            ->select('sum(t.pscDuree) as total')
            ->innerJoin('t.pscParcours', 'p')
            ->innerJoin('p.prcDcont', 'c')
            ->where('c.cntDaf = :daf')
            ->setParameter('daf', $daf)
            ->getQuery()
            ->getSingleScalarResult();
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
