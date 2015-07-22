<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class PresenceRepository extends EntityRepository
{
	public function getPresencesSession($id)
    {
        return $this
        ->createQueryBuilder('p')
        ->where('p.pscSession = :SessionId')
        ->setParameter('SessionId',$id)
        ;
    }
}