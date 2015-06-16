<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StructureT
 *
 * @ORM\Table(name="tb_StructureT")
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\StructureTRepository")
 */
class StructureT
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sty_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $styId;

    /**
     * @var string
     *
     * @ORM\Column(name="sty_Type", type="string", length=20, nullable=false)
     */
    private $styType;


    /**
     * Set styId
     *
     * @param integer $styId
     * @return StructureT
     */
    public function setStyId($styId)
    {
        $this->styId = $styId;

        return $this;
    }

    /**
     * Get styId
     *
     * @return integer
     */
    public function getStyId()
    {
        return $this->styId;
    }

    /**
     * Set styType
     *
     * @param string $styType
     * @return StructureT
     */
    public function setStyType($styType)
    {
        $this->styType = $styType;

        return $this;
    }

    /**
     * Get styType
     *
     * @return string 
     */
    public function getStyType()
    {
        return $this->styType;
    }
}
