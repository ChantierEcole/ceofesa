<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SessionT
 *
 * @ORM\Table(name="tb_SessionT")
 * @ORM\Entity
 */
class SessionT
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sty_ID", type="integer", nullable=false)
     * @ORM\Id
     */
    private $styId;

    /**
     * @var string
     *
     * @ORM\Column(name="sty_Type", type="string", length=10, nullable=false)
     */
    private $styType;


    /**
     * Set styId
     *
     * @param integer $styId
     * @return SessionT
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
     * @return SessionT
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
