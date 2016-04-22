<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\Presence;
use CEOFESABundle\Entity\Structure;
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

    public function getPresences(DAF $daf, Structure $structure)
    {
        return $this
            ->createQueryBuilder('p')
            ->leftJoin('p.pscParcours', 'parc')
            ->leftJoin('parc.prcDcont', 'd')
            ->leftJoin('parc.prcStructure', 's')
            ->leftJoin('parc.prcType', 'm')
            ->leftJoin('d.cntDaf', 'daf')
            ->andWhere('daf.dafId = :dafId')
            ->andWhere('m.mtyType = :type')
            ->andWhere('s.strId = :structure')
            ->setParameter('dafId', $daf)
            ->setParameter('type', 'EXTERNE')
            ->setParameter('structure', $structure)
            ;
    }

    public function checkBill(DAF $daf, Structure $structure)
    {
        $presences =  $this->getPresences($daf, $structure)->getQuery()->getResult();
        
        /** @var Presence $presence */
        foreach ($presences as $presence) {
            if (!$presence->getPscFacture()) {
                return true;
            }
        }

        return false;
    }
    
    public function checkPaid(DAF $daf, Structure $structure)
    {
        $presences =  $this->getPresences($daf, $structure)->getQuery()->getResult();

        /** @var Presence $presence */
        foreach ($presences as $presence) {
            if (!$presence->isPscPayee()) {
                return true;
            }
        }

        return false;
    }
}
