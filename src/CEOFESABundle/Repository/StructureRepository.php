<?php

namespace CEOFESABundle\Repository;

use Doctrine\ORM\EntityRepository;

class StructureRepository extends EntityRepository
{
    public function getUserStructure($id)
    {
        return $this
        ->createQueryBuilder('u')
        ->where('u.strId = :userStructureId')
        ->setParameter('userStructureId',$id)
        ->orderBy('u.strNom','ASC')
        ;
    }

    public function getOfesa()
    {
        return $this
        ->createQueryBuilder('o')
        ->where('o.strId = 2')
        ;
    }

    public function getOF()
    {
        return $this
        ->createQueryBuilder('f')
        ->where('f.strType = 2 OR f.strType = 3')
        ->orderBy('f.strNom','ASC')
        ;
    }

    public function getStructures()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.strType = 1')
        ->orderBy('s.strNom','ASC')
        ;
    }

    public function getSoustraitants()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.strType = 3')
        ->orderBy('s.strNom','ASC')
        ;
    }

    public function getIntra()
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.strType = 2')
        ->orderBy('s.strNom','DESC')
        ;
    }

    public function getSoustraitant($id)
    {
        return $this
        ->createQueryBuilder('s')
        ->where('s.strId = :ofId')
        ->setParameter('ofId',$id)
        ->orderBy('s.strNom','ASC')
        ;
    }

    public function getAllStructures()
    {
        return $this
        ->createQueryBuilder('s')
        ->orderBy('s.strNom','ASC')
        ;
    }
}