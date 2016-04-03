<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class AnimationRepository extends EntityRepository
{
    /**
     * @param int $id_session
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
	public function getFormateurs($id_session)
    {
        return $this
            ->createQueryBuilder('f')
            ->where('f.aniSession = :idSession')
            ->setParameter('idSession',$id_session);
    }

    public function checkFormateurAvailability($formateurId, \DateTime $date, $startHour, $endHour, $sessionId = null)
    {
        $baseDate = $date->format('Y-m-d');

        $start = new \DateTime($baseDate.' '.$startHour);
        $end = new \DateTime($baseDate.' '.$endHour);

        $qb = $this
            ->createQueryBuilder('a')
            ->innerJoin('a.aniTiers', 'f')
            ->innerJoin('a.aniSession', 's')
            ->andWhere('f.trsId = :formateurId')
            ->andWhere(":startDate <= CONCAT(s.sesDate, ' ', s.sesHeurefin)")
            ->andWhere(":endDate >= CONCAT(s.sesDate, ' ', s.sesHeuredebut)")
            ->setParameter('formateurId', $formateurId)
            ->setParameter('startDate', $start)
            ->setParameter('endDate', $end)
            ;

        if ($sessionId !== null) {
            $qb
                ->andWhere('s.sesId <> :sessionId')
                ->setParameter('sessionId', $sessionId);
        }

        return $qb->getQuery()->getResult();
    }
}
