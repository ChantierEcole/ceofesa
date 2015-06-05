<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class RelationRepository extends EntityRepository
{
    public function getRelation($idStructure,$idSousTraitant,$idOF){
    	return $this
    	->createQueryBuilder('rel')
        ->where('rel.relStructure = :idStructure')
        ->andWhere('rel.relSoustraitant = :idSousTraitant')
        ->andWhere('rel.relOf = :idOF')
        ->setParameters(array('idStructure' => $idStructure, 'idSousTraitant' => $idSousTraitant, 'idOF' => $idOF))
        ;
    }

}