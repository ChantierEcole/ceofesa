<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\Structure;
use CEOFESABundle\Entity\Tiers;
use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\DCont;
use Doctrine\ORM\EntityRepository;

class ParcoursRepository extends EntityRepository
{
    public function getParcours($idStructure, $idOF, $idModule, $idModuleType)
    {
        return $this
            ->createQueryBuilder('par')
            ->innerJoin('par.prcDcont', 'dcnt')
            ->innerJoin('dcnt.cntDaf', 'daf')
            ->innerJoin('dcnt.cntTiers', 'trs')
            ->where('par.prcStructure = :IdOF')
            ->andWhere('par.prcModule = :IdModule')
            ->andWhere('par.prcType = :IdModuleType')
            ->andWhere('daf.dafStructure = :IdStructure')
            ->setParameters(array('IdStructure' => $idStructure, 'IdOF' => $idOF, 'IdModule' => $idModule, 'IdModuleType' => $idModuleType))
            ->orderBy('trs.trsNom', 'ASC');
    }

    /**
     * @param $idStructure
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getParcoursByStructure($idStructure)
    {
        return $this
            ->createQueryBuilder('par')
            ->innerJoin('par.prcDcont', 'dcnt')
            ->innerJoin('dcnt.cntDaf', 'daf')
            ->where('daf.dafStructure = :IdStructure')
            ->setParameters(array('IdStructure' => $idStructure));
    }

    /**
     * @param Structure|null $structure
     * @param \DateTime      $start
     * @param \DateTime      $end
     *
     * @return array
     */
    public function getParcoursByStructureAndDate(Structure $structure = null, \DateTime $start, \DateTime $end)
    {
        $subQueryMonth = $this->createQueryBuilder('par1')
            ->select('SUM(pre1.pscDuree)')
            ->innerJoin('par1.prcPresence', 'pre1')
            ->innerJoin('pre1.pscSession', 'ses1')
            ->where('ses1.sesDate >= :dateDebut')
            ->andWhere('ses1.sesDate <= :dateFin')
            ->andWhere('par1 = par')
            ->getQuery()
            ->getDQL();

        $subQueryTotal = $this->createQueryBuilder('par2')
            ->select('SUM(pre2.pscDuree)')
            ->innerJoin('par2.prcPresence', 'pre2')
            ->innerJoin('pre2.pscSession', 'ses2')
            ->where('ses2.sesDate <= :dateFin')
            ->andWhere('par2 = par')
            ->getQuery()
            ->getDQL();

        $qb = $this
            ->createQueryBuilder('par')
            ->select('tiers.trsNom as nom')
            ->addSelect('tiers.trsPrenom as prenom')
            ->addSelect('daf.dafDossier as dossier')
            ->addSelect('typ.mtyType as type')
            ->addSelect('par.prcNombreheure as nombreHeurePrevue')
            ->addSelect('structur.strNom as structure')
            ->addSelect('('.$subQueryMonth.') AS nombreHeureMois')
            ->addSelect('('.$subQueryTotal.') AS nombreHeureCumulee')
            ->addSelect('module.modCode AS moduleCode')
            ->addSelect('module.modIntitule AS moduleIntitule')
            ->innerJoin('par.prcDcont','dcnt')
            ->innerJoin('dcnt.cntDaf','daf')
            ->innerJoin('dcnt.cntTiers', 'tiers')
            ->innerJoin('par.prcType', 'typ')
            ->innerJoin('par.prcStructure', 'structur')
            ->leftJoin('par.prcPresence', 'psc')
            ->leftJoin('psc.pscSession', 'session')
            ->leftJoin('par.prcModule', 'module')
            ->where('daf.dafStructure = :idStructure')
            ->andWhere('session.sesDate >= :dateDebut')
            ->andWhere('session.sesDate <= :dateFin')
            ->groupBy('par')
            ->setParameter('dateDebut', $start)
            ->setParameter('dateFin', $end);
        if ($structure != null) {
            $qb
                ->andWhere('daf.dafStructure = :structure')
                ->setParameter('structure', $structure);
        }

        $t = $qb->getQuery()->getScalarResult();
        return $qb->getQuery()->getScalarResult();
    }

    /**
     * @param Tiers     $tiers
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return array
     */
    public function getParcoursByTiers(Tiers $tiers, \DateTime $start, \DateTime $end)
    {
        $subQueryMonth = $this->createQueryBuilder('par1')
            ->select('SUM(pre1.pscDuree)')
            ->innerJoin('par1.prcPresence', 'pre1')
            ->innerJoin('pre1.pscSession', 'ses1')
            ->where('ses1.sesDate >= :dateDebut')
            ->andWhere('ses1.sesDate <= :dateFin')
            ->andWhere('par1 = par')
            ->getQuery()
            ->getDQL();

        $subQueryTotal = $this->createQueryBuilder('par2')
            ->select('SUM(pre2.pscDuree)')
            ->innerJoin('par2.prcPresence', 'pre2')
            ->innerJoin('pre2.pscSession', 'ses2')
            ->where('ses2.sesDate <= :dateFin')
            ->andWhere('par2 = par')
            ->getQuery()
            ->getDQL();

        return $this
            ->createQueryBuilder('par')
            ->select('tiers.trsNom as nom')
            ->addSelect('tiers.trsPrenom as prenom')
            ->addSelect('daf.dafDossier as dossier')
            ->addSelect('modul.modCode as module')
            ->addSelect('typ.mtyType as type')
            ->addSelect('par.prcNombreheure as nombreHeurePrevue')
            ->addSelect('structur.strNom as structure')
            ->addSelect('('.$subQueryMonth.') AS nombreHeureMois')
            ->addSelect('('.$subQueryTotal.') AS nombreHeureCumulee')
            ->innerJoin('par.prcDcont', 'dcnt')
            ->innerJoin('dcnt.cntDaf', 'daf')
            ->innerJoin('dcnt.cntTiers', 'tiers')
            ->innerJoin('par.prcModule', 'modul')
            ->innerJoin('par.prcType', 'typ')
            ->innerJoin('par.prcStructure', 'structur')
            ->leftJoin('par.prcPresence', 'psc')
            ->leftJoin('psc.pscSession', 'session')
            ->where('tiers = :tiers')
            ->andWhere('session.sesDate >= :dateDebut')
            ->andWhere('session.sesDate <= :dateFin')
            ->groupBy('nom')
            ->addGroupBy('prenom')
            ->addGroupBy('dossier')
            ->addGroupBy('module')
            ->addGroupBy('type')
            ->addGroupBy('structure')
            ->setParameter('tiers', $tiers)
            ->setParameter('dateDebut', $start)
            ->setParameter('dateFin', $end)
            ->getQuery()
            ->getScalarResult();
    }

    public function getParcoursAndSessions($idStructure, $idOF, $idModule, $idModuleType, $date)
    {
        return $this
            ->getParcours($idStructure, $idOF, $idModule, $idModuleType)
            ->addSelect('pre', 'ses')
            ->innerJoin('par.prcPresence', 'pre')
            ->innerJoin('pre.pscSession', 'ses')
            ->andWhere('ses.sesDate >= :dateMin')
            ->andWhere('ses.sesDate <= :dateMax')
            ->setParameter('dateMin', new \DateTime($date->format('Y-m-01')))
            ->setParameter('dateMax', new \DateTime($date->format('Y-m-t')))
            ->orderBy('ses.sesDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param DCont $dcont
     *
     * @return int
     */
    public function getDcontTotalHeures($dcont)
    {
        return $this
            ->createQueryBuilder('t')
            ->select('sum(t.prcNombreheure) as total')
            ->where('t.prcDcont = :dcont')
            ->setParameter('dcont', $dcont)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param DAF $daf
     *
     * @return int
     */
    public function getDafTotalHeures(DAF $daf)
    {
        return $this
            ->createQueryBuilder('t')
            ->select('sum(t.prcNombreheure) as total')
            ->innerJoin('t.prcDcont', 'c')
            ->where('c.cntDaf = :daf')
            ->setParameter('daf', $daf)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
