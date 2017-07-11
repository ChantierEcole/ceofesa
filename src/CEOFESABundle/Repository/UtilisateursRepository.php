<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class UtilisateursRepository extends EntityRepository
{
    public function getUsersStructure()
    {
        $queryBuilder = $this->createQueryBuilder('u')
            ->addSelect('structure')
            ->innerJoin('u.structure', 'structure');

        return $queryBuilder->getQuery()->getResult();
    }

	public function getMails($structure){
		$qb = $this->createQueryBuilder('m');
        $qb->select('m.email')
        ->where('m.structure = :structure')
        ->setParameter('structure', $structure)
        ;

        $results  = $qb->getQuery()->getResult();
        $mails = array();

    	foreach ($results as $result) {
        	$mails[] = $result['email'];
        }

        return $mails;
	}
}