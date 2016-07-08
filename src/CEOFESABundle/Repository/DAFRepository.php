<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\Session;
use Doctrine\ORM\EntityRepository;

class DAFRepository extends EntityRepository
{
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
