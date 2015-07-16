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
        ->orderBy('u.trsNom','ASC')
        ;
    }

    public function getStructureStagiaires($id_structure)
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.trsStructure = :StructureId')
        ->andWhere('s.trsType = 3')
        ->setParameter('StructureId',$id_structure)
        ->orderBy('s.trsNom','ASC')
        ;
    }

    public function getStructureFormateurs($id_structure)
    {
        return $this
        ->createQueryBuilder('f')
        ->where('f.trsStructure = :StructureId')
        ->andWhere('f.trsType = 5')
        ->setParameter('StructureId',$id_structure)
        ->orderBy('f.trsNom','ASC')
        ;
    }
}
