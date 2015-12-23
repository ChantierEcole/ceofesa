<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\Relation;
use Doctrine\ORM\EntityRepository;

class BonCdeRepository extends EntityRepository
{
    /**
     * @param $year
     * @param Relation $relation
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getBcdNumber($year, Relation $relation)
    {
    	$ret = $this
        	->createQueryBuilder('bcd')
            ->where('bcd.bcdAnnee = :year')
            ->andWhere('bcd.bcdRelation = :relation')
            ->orderBy('bcd.bcdNumero', 'DESC')
            ->setMaxResults(1)
            ->setParameter('year', $year)
            ->setParameter('relation', $relation)
            ->getQuery()->getOneOrNullResult();
        ;

        if ($ret) {
            return $ret->getBcdNumero() + 1;
        }

        return 1;
    }

    /**
     * @param $id
     * @return array
     */
    public function findByStructure($id)
    {
        $qb = $this
            ->createQueryBuilder('bcd')
            ->join('bcd.bcdDAF' , 'daf')
            ->join('daf.dafStructure', 'str')
            ->where('str.strId = :id')
            ->setParameter('id', $id)
            ->orderBy('bcd.bcdDate', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

}