<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parcours
 *
 * @ORM\Table(name="tb_Parcours", uniqueConstraints={@ORM\UniqueConstraint(name="unq_parcours", columns={"prc_DCont", "prc_Module", "prc_Type", "prc_Structure"})})
 * @ORM\Entity
 */
class Parcours
{
    /**
     * @var integer
     *
     * @ORM\Column(name="prc_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prcId;

    /**
     * @var \DCont
     *
     * @ORM\ManyToOne(targetEntity="DCont")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prc_DCont", referencedColumnName="cnt_ID", nullable=false)
     * })
     */
    private $prcDcont;

    /**
     * @var \ModuleT
     *
     * @ORM\ManyToOne(targetEntity="ModuleT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prc_Type", referencedColumnName="mty_ID", nullable=false)
     * })
     */
    private $prcType;

    /**
     * @var \Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prc_Structure", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $prcStructure;

    /**
     * @var \Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prc_Module", referencedColumnName="mod_ID", nullable=false)
     * })
     */
    private $prcModule;

    /**
     * @var string
     *
     * @ORM\Column(name="prc_NombreHeure", type="decimal", precision=10, scale=2, nullable=false , options={"default" = 0.00})
     */
    private $prcNombreheure;

    /**
     * @var \DParcours
     *
     * @ORM\ManyToOne(targetEntity="DParcours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prc_ImpDevis", referencedColumnName="dpr_ID")
     * })
     */
    private $prcImpdevis;



    /**
     * Get prcId
     *
     * @return integer 
     */
    public function getPrcId()
    {
        return $this->prcId;
    }

    /**
     * Set prcNombreheure
     *
     * @param string $prcNombreheure
     * @return Parcours
     */
    public function setPrcNombreheure($prcNombreheure)
    {
        $this->prcNombreheure = $prcNombreheure;

        return $this;
    }

    /**
     * Get prcNombreheure
     *
     * @return string 
     */
    public function getPrcNombreheure()
    {
        return $this->prcNombreheure;
    }

    /**
     * Set prcDcont
     *
     * @param \CEOFESABundle\Entity\DCont $prcDcont
     * @return Parcours
     */
    public function setPrcDcont(\CEOFESABundle\Entity\DCont $prcDcont = null)
    {
        $this->prcDcont = $prcDcont;

        return $this;
    }

    /**
     * Get prcDcont
     *
     * @return \CEOFESABundle\Entity\DCont 
     */
    public function getPrcDcont()
    {
        return $this->prcDcont;
    }

    /**
     * Set prcStructure
     *
     * @param \CEOFESABundle\Entity\Structure $prcStructure
     * @return Parcours
     */
    public function setPrcStructure(\CEOFESABundle\Entity\Structure $prcStructure = null)
    {
        $this->prcStructure = $prcStructure;

        return $this;
    }

    /**
     * Get prcStructure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getPrcStructure()
    {
        return $this->prcStructure;
    }

    /**
     * Set prcModule
     *
     * @param \CEOFESABundle\Entity\Module $prcModule
     * @return Parcours
     */
    public function setPrcModule(\CEOFESABundle\Entity\Module $prcModule = null)
    {
        $this->prcModule = $prcModule;

        return $this;
    }

    /**
     * Get prcModule
     *
     * @return \CEOFESABundle\Entity\Module 
     */
    public function getPrcModule()
    {
        return $this->prcModule;
    }

    /**
     * Set prcType
     *
     * @param \CEOFESABundle\Entity\ModuleT $prcType
     * @return Parcours
     */
    public function setPrcType(\CEOFESABundle\Entity\ModuleT $prcType = null)
    {
        $this->prcType = $prcType;

        return $this;
    }

    /**
     * Get prcType
     *
     * @return \CEOFESABundle\Entity\ModuleT
     */
    public function getPrcType()
    {
        return $this->prcType;
    }

    /**
     * Set prcImpdevis
     *
     * @param \CEOFESABundle\Entity\DParcours $prcImpdevis
     * @return Parcours
     */
    public function setPrcImpdevis(\CEOFESABundle\Entity\DParcours $prcImpdevis = null)
    {
        $this->prcImpdevis = $prcImpdevis;

        return $this;
    }

    /**
     * Get prcImpdevis
     *
     * @return \CEOFESABundle\Entity\DParcours 
     */
    public function getPrcImpdevis()
    {
        return $this->prcImpdevis;
    }
}
