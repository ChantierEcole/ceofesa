<?php

namespace CEOFESABundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BonCde
 *
 * @ORM\Table(name="tb_BonCde", uniqueConstraints={@ORM\UniqueConstraint(name="unq_boncde", columns={"bcd_Annee", "bcd_Numero", "bcd_Relation"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\BonCdeRepository")
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
     * @var DAF
     *
     * @ORM\ManyToOne(targetEntity="DAF", inversedBy="bcdBonCdes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bcd_DAF", referencedColumnName="daf_ID", nullable=true)
     * })
     */
    private $bcdDAF;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bcdSent", type="boolean", nullable=false, options={"default" = 0})
     */
    private $bcdSent;

    /**
     * @ORM\OneToMany(targetEntity="BParcours", mappedBy="bprBonCde", cascade={"persist"}, orphanRemoval=true)
     */
    protected $bcdBParcours;

    /**
     * BonCde constructor.
     */
    public function __construct()
    {
        $this->bcdBParcours = new ArrayCollection();
    }

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

    /**
     * Add bcdBParcours
     *
     * @param BParcours $bcdBParcours
     * @return DCont
     */
    public function addBcdBParcour(BParcours $bcdBParcours)
    {
        $bcdBParcours->setBprBonCde($this);
        $this->bcdBParcours[] = $bcdBParcours;

        return $this;
    }

    /**
     * Remove bcdBParcours
     *
     * @param BParcours $bcdBParcours
     */
    public function removeBcdBParcour(BParcours $bcdBParcours)
    {
        $this->bcdBParcours->removeElement($bcdBParcours);
    }

    /**
     * Get bcdBParcours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBcdBParcours()
    {
        return $this->bcdBParcours;
    }

    /**
     * @return DAF
     */
    public function getBcdDAF()
    {
        return $this->bcdDAF;
    }

    /**
     * @param DAF $bcdDAF
     */
    public function setBcdDAF($bcdDAF)
    {
        $this->bcdDAF = $bcdDAF;
    }

    /**
     * @return boolean
     */
    public function getBcdSent()
    {
        return $this->bcdSent;
    }

    /**
     * @param boolean $bcdSent
     */
    public function setBcdSent($bcdSent)
    {
        $this->bcdSent = $bcdSent;
    }

    /**
     * @return int
     */
    public function getTotalHeures()
    {
        $total = 0;

        foreach ($this->bcdBParcours as $parcours) {
            $total += $parcours->getBprNombreheure();
        }

        return $total;
    }

    /**
     * @return int
     */
    public function getTotalMontant()
    {
        $total = 0;

        foreach ($this->bcdBParcours as $parcours) {
            $total += $parcours->getMontant();
        }

        return $total;
    }
}
