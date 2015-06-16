<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CiviliteT
 *
 * @ORM\Table(name="tb_CiviliteT")
 * @ORM\Entity
 */
class CiviliteT
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="cty_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ctyId;

    /**
     * @var string
     *
     * @ORM\Column(name="cty_Type", type="string", length=10, nullable=false)
     */
    private $ctyType;

    /**
     * @var string
     *
     * @ORM\Column(name="cty_TypeCourt", type="string", length=3, nullable=false)
     */
    private $ctyTypecourt;

    /**
     * Get ctyId
     *
     * @return integer 
     */
    public function getCtyId()
    {
        return $this->ctyId;
    }

    /**
     * Set ctyId
     *
     * @param boolean $ctyTypecourt
     * @return CiviliteT
     */
    public function setCtyId($id)
    {
        $this->id = $id;
    }

    /**
     * Set ctyType
     *
     * @param string $ctyType
     * @return CiviliteT
     */
    public function setCtyType($ctyType)
    {
        $this->ctyType = $ctyType;

        return $this;
    }

    /**
     * Get ctyType
     *
     * @return string 
     */
    public function getCtyType()
    {
        return $this->ctyType;
    }

    /**
     * Set ctyTypecourt
     *
     * @param string $ctyTypecourt
     * @return CiviliteT
     */
    public function setCtyTypecourt($ctyTypecourt)
    {
        $this->ctyTypecourt = $ctyTypecourt;

        return $this;
    }

    /**
     * Get ctyTypecourt
     *
     * @return string 
     */
    public function getCtyTypecourt()
    {
        return $this->ctyTypecourt;
    }
}
