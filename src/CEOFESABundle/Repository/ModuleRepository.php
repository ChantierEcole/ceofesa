<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class ModuleRepository extends EntityRepository
{
	public function getModule($idModule)
    {
        return $this
            ->createQueryBuilder('m')
            ->where('m.modId = :id')
            ->setParameter('id', $idModule);
        ;
    }
}