<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationT
 *
 * @ORM\Table(name="tb_FormationT")
 * @ORM\Entity
 */
class FormationT
{
    /**
     * @var integer
     *
     * @ORM\Column(name="fty_ID", type="integer", nullable=false)
     * @ORM\Id
     */
    private $ftyId;

    /**
     * @var string
     *
     * @ORM\Column(name="fty_Type", type="string", length=10, nullable=false)
     */
    private $ftyType;


    /**
     * Set ftyId
     *
     * @param integer $ftyId
     * @return FormationT
     */
    public function setFtyId($ftyId)
    {
        $this->ftyId = $ftyId;

        return $this;
    }

    /**
     * Get ftyId
     *
     * @return integer
     */
    public function getFtyId()
    {
        return $this->ftyId;
    }

    /**
     * Set ftyType
     *
     * @param string $ftyType
     * @return FormationT
     */
    public function setFtyType($ftyType)
    {
        $this->ftyType = $ftyType;

        return $this;
    }

    /**
     * Get ftyType
     *
     * @return string 
     */
    public function getFtyType()
    {
        return $this->ftyType;
    }
}
