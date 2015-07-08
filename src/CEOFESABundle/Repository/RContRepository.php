<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class RContRepository extends EntityRepository
{
    public function getModules($idRelation)
    {
        return $this
            ->createQueryBuilder('m')
            ->where('m.rcnRelation = :relations')
            ->setParameter('relations', $idRelation);
        ;
    }
}