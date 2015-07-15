<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class AnimationRepository extends EntityRepository
{
	public function getFormateurs($id_session){
        return $this
        ->createQueryBuilder('f')
        ->where('f.aniSession = :idSession')
        ->setParameter('idSession',$id_session)
        ;
    }
}