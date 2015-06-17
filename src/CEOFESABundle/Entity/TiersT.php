<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TiersT
 *
 * @ORM\Table(name="tb_TiersT")
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\TiersTRepository")
 */
class TiersT
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tty_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ttyId;

    /**
     * @var string
     *
     * @ORM\Column(name="tty_Type", type="string", length=20, nullable=false)
     */
    private $ttyType;


    /**
     * Set ttyId
     *
     * @param integer $ttyId
     * @return TiersT
     */
    public function setTtyId($ttyId)
    {
        $this->ttyId = $ttyId;

        return $this;
    }

    /**
     * Get ttyId
     *
     * @return integer
     */
    public function getTtyId()
    {
        return $this->ttyId;
    }

    /**
     * Set ttyType
     *
     * @param string $ttyType
     * @return TiersT
     */
    public function setTtyType($ttyType)
    {
        $this->ttyType = $ttyType;

        return $this;
    }

    /**
     * Get ttyType
     *
     * @return string 
     */
    public function getTtyType()
    {
        return $this->ttyType;
    }
}
