<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BParcours
 *
 * @ORM\Table(name="tb_BParcours", uniqueConstraints={@ORM\UniqueConstraint(name="unq_bparcours", columns={"bpr_BonCde", "bpr_Parcours"})})
 * @ORM\Entity
 */
class BParcours
{
    /**
     * @var integer
     *
     * @ORM\Column(name="bpr_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bprId;

    /**
     * @var \BonCde
     *
     * @ORM\ManyToOne(targetEntity="BonCde")
     * @ORM\JoinColumn(name="bpr_BonCde", referencedColumnName="bcd_ID", nullable=false)
     *
     */
    private $bprBonCde;

    /**
     * @var \Parcours
     *
     * @ORM\ManyToOne(targetEntity="Parcours")
     * @ORM\JoinColumn(name="bpr_Parcours", referencedColumnName="prc_ID", nullable=false)
     * 
     */
    private $bprParcours;

    /**
     * @var string
     *
     * @ORM\Column(name="bpr_NombreHeure", type="decimal", precision=10, scale=2, nullable=false, options={"default" = 0.00})
     */
    private $bprNombreheure;

    /**
     * @var string
     *
     * @ORM\Column(name="bpr_TauxHoraire", type="decimal", precision=10, scale=2, nullable=false, options={"default" = 0.00})
     */
    private $bprTauxhoraire;

    



    /**
     * Get bprId
     *
     * @return integer 
     */
    public function getBprId()
    {
        return $this->bprId;
    }

    /**
     * Set bprNombreheure
     *
     * @param string $bprNombreheure
     * @return BParcours
     */
    public function setBprNombreheure($bprNombreheure)
    {
        $this->bprNombreheure = $bprNombreheure;

        return $this;
    }

    /**
     * Get bprNombreheure
     *
     * @return string 
     */
    public function getBprNombreheure()
    {
        return $this->bprNombreheure;
    }

    /**
     * Set bprTauxhoraire
     *
     * @param string $bprTauxhoraire
     * @return BParcours
     */
    public function setBprTauxhoraire($bprTauxhoraire)
    {
        $this->bprTauxhoraire = $bprTauxhoraire;

        return $this;
    }

    /**
     * Get bprTauxhoraire
     *
     * @return string 
     */
    public function getBprTauxhoraire()
    {
        return $this->bprTauxhoraire;
    }

    /**
     * Set bprBonCde
     *
     * @param \CEOFESABundle\Entity\BonCde $bprBonCde
     * @return BParcours
     */
    public function setBprBonCde(\CEOFESABundle\Entity\BonCde $bprBonCde = null)
    {
        $this->bprBonCde = $bprBonCde;

        return $this;
    }

    /**
     * Get bprBonCde
     *
     * @return \CEOFESABundle\Entity\BonCde 
     */
    public function getBprBonCde()
    {
        return $this->bprBonCde;
    }

    /**
     * Set bprParcours
     *
     * @param \CEOFESABundle\Entity\Parcours $bprParcours
     * @return BParcours
     */
    public function setBprParcours(\CEOFESABundle\Entity\Parcours $bprParcours = null)
    {
        $this->bprParcours = $bprParcours;

        return $this;
    }

    /**
     * Get bprParcours
     *
     * @return \CEOFESABundle\Entity\Parcours 
     */
    public function getBprParcours()
    {
        return $this->bprParcours;
    }
}
