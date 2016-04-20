<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class TiersTRepository extends EntityRepository
{
    public function getStagiaireType()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.ttyId = 3')
        ;
    }

    public function getFormateurType()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.ttyId = 5')
        ;
    }
}
