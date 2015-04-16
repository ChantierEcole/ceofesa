<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DParcours
 *
 * @ORM\Table(name="tb_DParcours", uniqueConstraints={@ORM\UniqueConstraint(name="unq_dparcours", columns={"dpr_Devis", "dpr_Tiers", "dpr_Type", "dpr_Module", "dpr_Structure"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\DParcoursRepository")
 */
class DParcours
{
    /**
     * @var integer
     *
     * @ORM\Column(name="dpr_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $dprId;

    /**
     * @var \Devis
     *
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="devParcours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dpr_Devis", referencedColumnName="dev_ID", nullable=false)
     * })
     */
    private $dprDevis;

    /**
     * @var \Tiers
     *
     * @ORM\ManyToOne(targetEntity="Tiers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dpr_Tiers", referencedColumnName="trs_ID", nullable=false)
     * })
     */
    private $dprTiers;

    /**
     * @var \ModuleT
     *
     * @ORM\ManyToOne(targetEntity="ModuleT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dpr_Type", referencedColumnName="mty_ID", nullable=false)
     * })
     */
    private $dprType;

    /**
     * @var \Structure
     *
     * @ORM\ManyToOne(targetEntity="Structure")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dpr_Structure", referencedColumnName="str_ID", nullable=false)
     * })
     */
    private $dprStructure;

    /**
     * @var \Module
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dpr_Module", referencedColumnName="mod_ID", nullable=false)
     * })
     */
    private $dprModule;

    /**
     * @var decimal
     *
     * @ORM\Column(name="dpr_NombreHeure", type="decimal", precision=10, scale=2, nullable=false, options={"default" = 0.00})
     */
    private $dprNombreheure;

    /**
     * @var integer
     *
     * @ORM\Column(name="dpr_Numero", type="integer", nullable=false, options={"default" = 0})
     */
    private $dprNumero;

    /**
     * Get dprId
     *
     * @return integer 
     */
    public function getDprId()
    {
        return $this->dprId;
    }

    /**
     * Set dprNombreheure
     *
     * @param string $dprNombreheure
     * @return DParcours
     */
    public function setDprNombreheure($dprNombreheure)
    {
        $this->dprNombreheure = $dprNombreheure;

        return $this;
    }

    /**
     * Get dprNombreheure
     *
     * @return string 
     */
    public function getDprNombreheure()
    {
        return $this->dprNombreheure;
    }

    /**
     * Set dprNumero
     *
     * @param integer $dprNumero
     * @return DParcours
     */
    public function setDprNumero($dprNumero)
    {
        $this->dprNumero = $dprNumero;

        return $this;
    }

    /**
     * Get dprNumero
     *
     * @return integer 
     */
    public function getDprNumero()
    {
        return $this->dprNumero;
    }

    /**
     * Set dprDevis
     *
     * @param \CEOFESABundle\Entity\Devis $dprDevis
     * @return DParcours
     */
    public function setDprDevis(\CEOFESABundle\Entity\Devis $dprDevis)
    {
        $this->dprDevis = $dprDevis;

        return $this;
    }

    /**
     * Get dprDevis
     *
     * @return \CEOFESABundle\Entity\Devis 
     */
    public function getDprDevis()
    {
        return $this->dprDevis;
    }

    /**
     * Set dprTiers
     *
     * @param \CEOFESABundle\Entity\Tiers $dprTiers
     * @return DParcours
     */
    public function setDprTiers(\CEOFESABundle\Entity\Tiers $dprTiers)
    {
        $this->dprTiers = $dprTiers;

        return $this;
    }

    /**
     * Get dprTiers
     *
     * @return \CEOFESABundle\Entity\Tiers 
     */
    public function getDprTiers()
    {
        return $this->dprTiers;
    }

    /**
     * Set dprType
     *
     * @param \CEOFESABundle\Entity\ModuleT $dprType
     * @return DParcours
     */
    public function setDprType(\CEOFESABundle\Entity\ModuleT $dprType)
    {
        $this->dprType = $dprType;

        return $this;
    }

    /**
     * Get dprType
     *
     * @return \CEOFESABundle\Entity\ModuleT 
     */
    public function getDprType()
    {
        return $this->dprType;
    }

    /**
     * Set dprStructure
     *
     * @param \CEOFESABundle\Entity\Structure $dprStructure
     * @return DParcours
     */
    public function setDprStructure(\CEOFESABundle\Entity\Structure $dprStructure)
    {
        $this->dprStructure = $dprStructure;

        return $this;
    }

    /**
     * Get dprStructure
     *
     * @return \CEOFESABundle\Entity\Structure 
     */
    public function getDprStructure()
    {
        return $this->dprStructure;
    }

    /**
     * Set dprModule
     *
     * @param \CEOFESABundle\Entity\Module $dprModule
     * @return DParcours
     */
    public function setDprModule(\CEOFESABundle\Entity\Module $dprModule)
    {
        $this->dprModule = $dprModule;

        return $this;
    }

    /**
     * Get dprModule
     *
     * @return \CEOFESABundle\Entity\Module 
     */
    public function getDprModule()
    {
        return $this->dprModule;
    }
}
