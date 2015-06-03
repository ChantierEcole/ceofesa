<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class RContRepository extends EntityRepository
{
    public function getModules($id_structure,$id_tiers)
    {
        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select('rel.relId')
            ->from('CEOFESABundle\Entity\Relation', 'rel')
            ->where('rel.relStructure = :idStructure')
            ->setParameter('idStructure',$id_structure)
        ;

        return $qb2;

        /*return $this
        ->createQueryBuilder('m')
        ->where('m.trsStructure = :StructureId')
        ->setParameter('StructureId',$id_structure)
        ->orderBy('u.trsNom','ASC')
        ;*/
    } 
}