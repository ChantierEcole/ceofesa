<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\DAF;
use CEOFESABundle\Entity\Session;
use CEOFESABundle\Entity\Structure;
use Doctrine\ORM\EntityRepository;

class DAFRepository extends EntityRepository
{
    /*public function getSoustraitantsHeuresTotal(DAF $daf)
    {
        return $this
            ->createQueryBuilder('d')
            ->select('s.strId, s.strNom, SUM(p.prcNombreheure) as nbHeures')
            ->leftJoin('d.dafDcont', 'dc')
            ->leftJoin('dc.cntParcours', 'p')
            ->leftJoin('p.prcType', 'm')
            ->leftJoin('p.prcStructure', 's')
            ->andWhere('d.dafId = :dafId')
            ->andWhere('m.mtyType = :type')
            ->distinct('dc')
            ->groupBy('s.strId, dc')
            ->setParameter('dafId', $daf)
            ->setParameter('type', 'EXTERNE')
            ;
    }
    
    public function getPresences(DAF $daf, Structure $structure)
    {
        return $this
            ->createQueryBuilder('d')
           // ->update('pres.pscFacture', true)
            ->select('pres')
            ->leftJoin('d.dafDcont', 'dc')
            ->leftJoin('dc.cntParcours', 'p')
            ->leftJoin('p.prcType', 'm')
            ->leftJoin('p.prcStructure', 's')
            ->leftJoin('p.prcPresence', 'pres')
            ->andWhere('d.dafId = :dafId')
            ->andWhere('m.mtyType = :type')
            ->andWhere('s.strId = :strId')
            ->setParameter('dafId', $daf)
            ->setParameter('type', 'EXTERNE')
            ->setParameter('strId', $structure)
            ;
    }*/

    /**
     * @param \CEOFESABundle\Entity\Session $session
     *
     * @return \CEOFESABundle\Entity\DAF
     */
    public function getDaf(Session $session)
    {
        return $this
            ->createQueryBuilder('d')
            ->leftJoin('d.dafDcont', 'dc')
            ->leftJoin('dc.cntParcours', 'prc')
            ->leftJoin('prc.prcPresence', 'pr')
            ->leftJoin('pr.pscSession', 's')
            ->andWhere('s.sesId = :session')
            ->setParameter('session', $session)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
