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
     * Get ttyId
     *
     * @return boolean 
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
