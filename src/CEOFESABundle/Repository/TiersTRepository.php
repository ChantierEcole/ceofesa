<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class TiersTRepository extends EntityRepository
{
    public function getStagiaireTypeBuilder()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.ttyId = 3')
        ;
    }
}
