<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="tb_Relation", uniqueConstraints={@ORM\UniqueConstraint(name="unq_relation", columns={"rel_Structure", "rel_SousTraitant", "rel_OF"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\RelationRepository")
 */
class Relation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rel_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $relId;

    /**
     * @var Structure
     *
     * @ORM\ManyToOne(
     *     targetEntity = "CEOFESABundle\Entity\Structure",
     *     inversedBy   = "strRelations"
     * )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rel_Structure", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $relStructure;

    /**
     * @var Structure
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rel_OF", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $relOf;

    /**
     * @var Structure
     *
     * @ORM\ManyToOne(targetEntity="CEOFESABundle\Entity\Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rel_SousTraitant", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $relSoustraitant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rel_EnvoiConvention", type="boolean", nullable=true, options={"default" = 0})
     */
    private $relEnvoiconvention;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rel_EnvoiAvenant", type="boolean", nullable=true, options={"default" = 0})
     */
    private $relEnvoiavenant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rel_RetourConvention", type="boolean", nullable=true, options={"default" = 0})
     */
    private $relRetourconvention;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rel_RetourAvenant", type="boolean", nullable=true, options={"default" = 0})
     */
    private $relRetouravenant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateDebut", type="datetime", nullable=true)
     */
    private $relDatedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateFin", type="datetime", nullable=true)
     */
    private $relDatefin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateEnvoiConvention", type="datetime", nullable=true)
     */
    private $relDateenvoiconvention;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateRetourConvention", type="datetime", nullable=true)
     */
    private $relDateretourconvention;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateEnvoiAvenant", type="datetime", nullable=true)
     */
    private $relDateenvoiavenant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateRetourAvenant", type="datetime", nullable=true)
     */
    private $relDateretouravenant;

    /**
     * @var integer
     *
     * @ORM\Column(name="rel_NumConvention", type="integer", nullable=true, options={"default" = 0})
     */
    private $relNumconvention;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateProlongation", type="datetime", nullable=true)
     */
    private $relDateprolongation;

    /**
     * @var string
     *
     * @ORM\Column(name="rel_Tarif1", type="decimal", precision=5, scale=2, nullable=true, options={"default" = 10.00})
     */
    private $relTarif1;

    /**
     * @var string
     *
     * @ORM\Column(name="rel_Tarif2", type="decimal", precision=5, scale=2, nullable=true, options={"default" = 15.00})
     */
    private $relTarif2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateTarif1", type="datetime", nullable=true, options={"default" = "2012-10-01 00:00:00"})
     */
    private $relDatetarif1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rel_DateTarif2", type="datetime", nullable=true, options={"default" = "2013-04-01 00:00:00"})
     */
    private $relDatetarif2 = '';


    public function __construct()
    {
        $this->relDatetarif1 = new \DateTime('2012-10-01 00:00:00');
        $this->relDatetarif2 = new \DateTime('2013-04-01 00:00:00');
    }

    /**
     * Get relId
     *
     * @return integer 
     */
    public function getRelId()
    {
        return $this->relId;
    }

    /**
     * Set relEnvoiconvention
     *
     * @param boolean $relEnvoiconvention
     * @return Relation
     */
    public function setRelEnvoiconvention($relEnvoiconvention)
    {
        $this->relEnvoiconvention = $relEnvoiconvention;

        return $this;
    }

    /**
     * Get relEnvoiconvention
     *
     * @return boolean 
     */
    public function getRelEnvoiconvention()
    {
        return $this->relEnvoiconvention;
    }

    /**
     * Set relEnvoiavenant
     *
     * @param boolean $relEnvoiavenant
     * @return Relation
     */
    public function setRelEnvoiavenant($relEnvoiavenant)
    {
        $this->relEnvoiavenant = $relEnvoiavenant;

        return $this;
    }

    /**
     * Get relEnvoiavenant
     *
     * @return boolean 
     */
    public function getRelEnvoiavenant()
    {
        return $this->relEnvoiavenant;
    }

    /**
     * Set relRetourconvention
     *
     * @param boolean $relRetourconvention
     * @return Relation
     */
    public function setRelRetourconvention($relRetourconvention)
    {
        $this->relRetourconvention = $relRetourconvention;

        return $this;
    }

    /**
     * Get relRetourconvention
     *
     * @return boolean 
     */
    public function getRelRetourconvention()
    {
        return $this->relRetourconvention;
    }

    /**
     * Set relRetouravenant
     *
     * @param boolean $relRetouravenant
     * @return Relation
     */
    public function setRelRetouravenant($relRetouravenant)
    {
        $this->relRetouravenant = $relRetouravenant;

        return $this;
    }

    /**
     * Get relRetouravenant
     *
     * @return boolean 
     */
    public function getRelRetouravenant()
    {
        return $this->relRetouravenant;
    }

    /**
     * Set relDatedebut
     *
     * @param \DateTime $relDatedebut
     * @return Relation
     */
    public function setRelDatedebut($relDatedebut)
    {
        $this->relDatedebut = $relDatedebut;

        return $this;
    }

    /**
     * Get relDatedebut
     *
     * @return \DateTime 
     */
    public function getRelDatedebut()
    {
        return $this->relDatedebut;
    }

    /**
     * Set relDatefin
     *
     * @param \DateTime $relDatefin
     * @return Relation
     */
    public function setRelDatefin($relDatefin)
    {
        $this->relDatefin = $relDatefin;

        return $this;
    }

    /**
     * Get relDatefin
     *
     * @return \DateTime 
     */
    public function getRelDatefin()
    {
        return $this->relDatefin;
    }

    /**
     * Set relDateenvoiconvention
     *
     * @param \DateTime $relDateenvoiconvention
     * @return Relation
     */
    public function setRelDateenvoiconvention($relDateenvoiconvention)
    {
        $this->relDateenvoiconvention = $relDateenvoiconvention;

        return $this;
    }

    /**
     * Get relDateenvoiconvention
     *
     * @return \DateTime 
     */
    public function getRelDateenvoiconvention()
    {
        return $this->relDateenvoiconvention;
    }

    /**
     * Set relDateretourconvention
     *
     * @param \DateTime $relDateretourconvention
     * @return Relation
     */
    public function setRelDateretourconvention($relDateretourconvention)
    {
        $this->relDateretourconvention = $relDateretourconvention;

        return $this;
    }

    /**
     * Get relDateretourconvention
     *
     * @return \DateTime 
     */
    public function getRelDateretourconvention()
    {
        return $this->relDateretourconvention;
    }

    /**
     * Set relDateenvoiavenant
     *
     * @param \DateTime $relDateenvoiavenant
     * @return Relation
     */
    public function setRelDateenvoiavenant($relDateenvoiavenant)
    {
        $this->relDateenvoiavenant = $relDateenvoiavenant;

        return $this;
    }

    /**
     * Get relDateenvoiavenant
     *
     * @return \DateTime 
     */
    public function getRelDateenvoiavenant()
    {
        return $this->relDateenvoiavenant;
    }

    /**
     * Set relDateretouravenant
     *
     * @param \DateTime $relDateretouravenant
     * @return Relation
     */
    public function setRelDateretouravenant($relDateretouravenant)
    {
        $this->relDateretouravenant = $relDateretouravenant;

        return $this;
    }

    /**
     * Get relDateretouravenant
     *
     * @return \DateTime 
     */
    public function getRelDateretouravenant()
    {
        return $this->relDateretouravenant;
    }

    /**
     * Set relNumconvention
     *
     * @param integer $relNumconvention
     * @return Relation
     */
    public function setRelNumconvention($relNumconvention)
    {
        $this->relNumconvention = $relNumconvention;

        return $this;
    }

    /**
     * Get relNumconvention
     *
     * @return integer 
     */
    public function getRelNumconvention()
    {
        return $this->relNumconvention;
    }

    /**
     * Set relDateprolongation
     *
     * @param \DateTime $relDateprolongation
     * @return Relation
     */
    public function setRelDateprolongation($relDateprolongation)
    {
        $this->relDateprolongation = $relDateprolongation;

        return $this;
    }

    /**
     * Get relDateprolongation
     *
     * @return \DateTime 
     */
    public function getRelDateprolongation()
    {
        return $this->relDateprolongation;
    }

    /**
     * Set relTarif1
     *
     * @param string $relTarif1
     * @return Relation
     */
    public function setRelTarif1($relTarif1)
    {
        $this->relTarif1 = $relTarif1;

        return $this;
    }

    /**
     * Get relTarif1
     *
     * @return string 
     */
    public function getRelTarif1()
    {
        return $this->relTarif1;
    }

    /**
     * Set relTarif2
     *
     * @param string $relTarif2
     * @return Relation
     */
    public function setRelTarif2($relTarif2)
    {
        $this->relTarif2 = $relTarif2;

        return $this;
    }

    /**
     * Get relTarif2
     *
     * @return string 
     */
    public function getRelTarif2()
    {
        return $this->relTarif2;
    }

    /**
     * Set relDatetarif1
     *
     * @param \DateTime $relDatetarif1
     * @return Relation
     */
    public function setRelDatetarif1($relDatetarif1)
    {
        $this->relDatetarif1 = $relDatetarif1;

        return $this;
    }

    /**
     * Get relDatetarif1
     *
     * @return \DateTime 
     */
    public function getRelDatetarif1()
    {
        return $this->relDatetarif1;
    }

    /**
     * Set relDatetarif2
     *
     * @param \DateTime $relDatetarif2
     * @return Relation
     */
    public function setRelDatetarif2($relDatetarif2)
    {
        $this->relDatetarif2 = $relDatetarif2;

        return $this;
    }

    /**
     * Get relDatetarif2
     *
     * @return \DateTime 
     */
    public function getRelDatetarif2()
    {
        return $this->relDatetarif2;
    }

    /**
     * Set relStructure
     *
     * @param \CEOFESABundle\Entity\Structure $relStructure
     * @return Relation
     */
    public function setRelStructure(\CEOFESABundle\Entity\Structure $relStructure = null)
    {
        $this->relStructure = $relStructure;

        return $this;
    }

    /**
     * Get relStructure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getRelStructure()
    {
        return $this->relStructure;
    }

    /**
     * Set relOf
     *
     * @param \CEOFESABundle\Entity\Structure $relOf
     * @return Relation
     */
    public function setRelOf(\CEOFESABundle\Entity\Structure $relOf = null)
    {
        $this->relOf = $relOf;

        return $this;
    }

    /**
     * Get relOf
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getRelOf()
    {
        return $this->relOf;
    }

    /**
     * Set relSoustraitant
     *
     * @param \CEOFESABundle\Entity\Structure $relSoustraitant
     * @return Relation
     */
    public function setRelSoustraitant(\CEOFESABundle\Entity\Structure $relSoustraitant = null)
    {
        $this->relSoustraitant = $relSoustraitant;

        return $this;
    }

    /**
     * Get relSoustraitant
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getRelSoustraitant()
    {
        return $this->relSoustraitant;
    }
}
