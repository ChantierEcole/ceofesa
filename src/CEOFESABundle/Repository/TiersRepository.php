<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class TiersRepository extends EntityRepository
{
    public function getStructureTiers($id_structure)
    {
        return $this
        ->createQueryBuilder('u')
        ->where('u.trsStructure = :StructureId')
        ->setParameter('StructureId',$id_structure)
        ;
    } 
}
