<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class ModuleTRepository extends EntityRepository
{
	public function getModuleType($id)
    {
        return $this
            ->createQueryBuilder('m')
            ->where('m.mtyId = :id')
            ->setParameter('id', $id);
        ;
    }
}