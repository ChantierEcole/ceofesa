<?php

namespace CEOFESABundle\Repository;

use CEOFESABundle\Entity\Relation;
use Doctrine\ORM\EntityRepository;

class BonCdeRepository extends EntityRepository
{
    public function getBcdNumber($year, Relation $relation){
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

}