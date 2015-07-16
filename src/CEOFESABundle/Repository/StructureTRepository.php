<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class StructureTRepository extends EntityRepository
{
    public function getSoustraitantType()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.styId = 3')
        ;
    }
}
