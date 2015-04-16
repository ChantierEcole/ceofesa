<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleT
 *
 * @ORM\Table(name="tb_ModuleT")
 * @ORM\Entity
 */
class ModuleT
{
    /**
     * @var integer
     *
     * @ORM\Column(name="mty_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $mtyId;

    /**
     * @var string
     *
     * @ORM\Column(name="mty_Type", type="string", length=10, nullable=false)
     */
    private $mtyType;

    /**
     * @var \StructureT
     *
     * @ORM\ManyToOne(targetEntity="StructureT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mty_StructureType", referencedColumnName="sty_ID")
     * })
     */
    private $mtyStructuretype;



    /**
     * Get mtyId
     *
     * @return boolean 
     */
    public function getMtyId()
    {
        return $this->mtyId;
    }

    /**
     * Set mtyType
     *
     * @param string $mtyType
     * @return ModuleT
     */
    public function setMtyType($mtyType)
    {
        $this->mtyType = $mtyType;

        return $this;
    }

    /**
     * Get mtyType
     *
     * @return string 
     */
    public function getMtyType()
    {
        return $this->mtyType;
    }

    /**
     * Set mtyStructuretype
     *
     * @param \CEOFESABundle\Entity\StructureT $mtyStructuretype
     * @return ModuleT
     */
    public function setMtyStructuretype(\CEOFESABundle\Entity\StructureT $mtyStructuretype = null)
    {
        $this->mtyStructuretype = $mtyStructuretype;

        return $this;
    }

    /**
     * Get mtyStructuretype
     *
     * @return \CEOFESABundle\Entity\StructureT
     */
    public function getMtyStructuretype()
    {
        return $this->mtyStructuretype;
    }
}
