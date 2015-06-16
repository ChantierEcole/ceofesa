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
     * @var integer
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
     * Set ctyId
     *
     * @param integer $ctyId
     * @return CiviliteT
     */
    public function setCtyId($ctyId)
    {
        $this->ctyId = $ctyId;

        return $this;
    }

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
