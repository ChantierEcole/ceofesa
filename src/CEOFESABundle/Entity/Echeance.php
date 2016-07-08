<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Echeance
 *
 * @ORM\Table(name="tb_Echeance", uniqueConstraints={@ORM\UniqueConstraint(name="ECHEANCE", columns={"ech_DAF", "ech_Date"})}, indexes={@ORM\Index(name="trs_Date", columns={"ech_Date"})})
 * @ORM\Entity
 */
class Echeance
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ech_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $echId;

    /**
     * @var DAF
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\DAF")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ech_DAF", referencedColumnName="daf_ID", nullable=false)
     * })
     */
    private $echDaf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ech_Date", type="date", nullable=false)
     */
    private $echDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ech_Facture", type="boolean", nullable=true, options={"default" = 0})
     */
    private $echFacture;



    /**
     * Get echId
     *
     * @return integer 
     */
    public function getEchId()
    {
        return $this->echId;
    }

    /**
     * Set echDate
     *
     * @param \DateTime $echDate
     * @return Echeance
     */
    public function setEchDate($echDate)
    {
        $this->echDate = $echDate;

        return $this;
    }

    /**
     * Get echDate
     *
     * @return \DateTime 
     */
    public function getEchDate()
    {
        return $this->echDate;
    }

    /**
     * Set echFacture
     *
     * @param boolean $echFacture
     * @return Echeance
     */
    public function setEchFacture($echFacture)
    {
        $this->echFacture = $echFacture;

        return $this;
    }

    /**
     * Get echFacture
     *
     * @return boolean 
     */
    public function getEchFacture()
    {
        return $this->echFacture;
    }

    /**
     * Set echDaf
     *
     * @param \CEOFESABundle\Entity\DAF $echDaf
     * @return Echeance
     */
    public function setEchDaf(\CEOFESABundle\Entity\DAF $echDaf = null)
    {
        $this->echDaf = $echDaf;

        return $this;
    }

    /**
     * Get echDaf
     *
     * @return \CEOFESABundle\Entity\DAF
     */
    public function getEchDaf()
    {
        return $this->echDaf;
    }
}
