<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class DAFRepository extends EntityRepository
{

    /**
     * @param $id
     *
     * @return array
     */
    public function getDafByStructure($id)
    {
        $qb = $this->createQueryBuilder('d')
            ->addSelect('dafOf')
            ->addSelect('dafDcont')
            ->addSelect('cntParcours')
            ->addSelect('cntTiers')
            ->innerJoin('d.dafOf', 'dafOf')
            ->innerJoin('d.dafDcont', 'dafDcont')
            ->innerJoin('dafDcont.cntParcours', 'cntParcours')
            ->innerJoin('dafDcont.cntTiers', 'cntTiers')
            ->andWhere('d.dafStructure = :id')
            ->setParameter('id', $id)
            ->orderBy('d.dafDatedebut');

        return $qb->getQuery()->getResult();
    }
}
