<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BonCde
 *
 * @ORM\Table(name="tb_BonCde", uniqueConstraints={@ORM\UniqueConstraint(name="unq_boncde", columns={"bcd_Annee", "bcd_Numero", "bcd_Relation"})})
 * @ORM\Entity
 */
class BonCde
{
    /**
     * @var integer
     *
     * @ORM\Column(name="bcd_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bcdId;

    /**
     * @var string
     *
     * @ORM\Column(name="bcd_Annee", type="string", length=4, nullable=false)
     */
    private $bcdAnnee;

    /**
     * @var integer
     *
     * @ORM\Column(name="bcd_Numero", type="integer", nullable=true, options={"default" = 0})
     */
    private $bcdNumero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bcd_Date", type="datetime", nullable=false)
     */
    private $bcdDate;

    /**
     * @var \Relation
     *
     * @ORM\ManyToOne(targetEntity="Relation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bcd_Relation", referencedColumnName="rel_ID", nullable=false)
     * })
     */
    private $bcdRelation;



    /**
     * Get bcdId
     *
     * @return integer 
     */
    public function getBcdId()
    {
        return $this->bcdId;
    }

    /**
     * Set bcdAnnee
     *
     * @param string $bcdAnnee
     * @return BonCde
     */
    public function setBcdAnnee($bcdAnnee)
    {
        $this->bcdAnnee = $bcdAnnee;

        return $this;
    }

    /**
     * Get bcdAnnee
     *
     * @return string 
     */
    public function getBcdAnnee()
    {
        return $this->bcdAnnee;
    }

    /**
     * Set bcdNumero
     *
     * @param integer $bcdNumero
     * @return BonCde
     */
    public function setBcdNumero($bcdNumero)
    {
        $this->bcdNumero = $bcdNumero;

        return $this;
    }

    /**
     * Get bcdNumero
     *
     * @return integer 
     */
    public function getBcdNumero()
    {
        return $this->bcdNumero;
    }

    /**
     * Set bcdDate
     *
     * @param \DateTime $bcdDate
     * @return BonCde
     */
    public function setBcdDate($bcdDate)
    {
        $this->bcdDate = $bcdDate;

        return $this;
    }

    /**
     * Get bcdDate
     *
     * @return \DateTime 
     */
    public function getBcdDate()
    {
        return $this->bcdDate;
    }

    /**
     * Set bcdRelation
     *
     * @param \CEOFESABundle\Entity\Relation $bcdRelation
     * @return BonCde
     */
    public function setBcdRelation(\CEOFESABundle\Entity\Relation $bcdRelation = null)
    {
        $this->bcdRelation = $bcdRelation;

        return $this;
    }

    /**
     * Get bcdRelation
     *
     * @return \CEOFESABundle\Entity\Relation 
     */
    public function getBcdRelation()
    {
        return $this->bcdRelation;
    }
}
