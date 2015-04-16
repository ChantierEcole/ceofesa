<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DCont
 *
 * @ORM\Table(name="tb_DCont", indexes={@ORM\Index(name="unq_dcont", columns={"cnt_DAF", "cnt_Tiers"})})
 * @ORM\Entity
 */
class DCont
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cnt_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cntId;

    /**
     * @var \DAF
     *
     * @ORM\ManyToOne(targetEntity="DAF")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cnt_DAF", referencedColumnName="daf_ID", nullable=false)
     * })
     */
    private $cntDaf;

    /**
     * @var \Tiers
     *
     * @ORM\ManyToOne(targetEntity="Tiers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cnt_Tiers", referencedColumnName="trs_ID", nullable=false)
     * })
     */
    private $cntTiers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cnt_DateSortie", type="date", nullable=true)
     */
    private $cntDatesortie;

    /**
     * @var \SortieT
     *
     * @ORM\ManyToOne(targetEntity="SortieT")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cnt_MotifSortie", referencedColumnName="srt_ID", nullable=false)
     * })
     */
    private $cntMotifsortie;



    /**
     * Get cntId
     *
     * @return integer 
     */
    public function getCntId()
    {
        return $this->cntId;
    }

    /**
     * Set cntDatesortie
     *
     * @param \DateTime $cntDatesortie
     * @return DCont
     */
    public function setCntDatesortie($cntDatesortie)
    {
        $this->cntDatesortie = $cntDatesortie;

        return $this;
    }

    /**
     * Get cntDatesortie
     *
     * @return \DateTime 
     */
    public function getCntDatesortie()
    {
        return $this->cntDatesortie;
    }

    /**
     * Set cntDaf
     *
     * @param \CEOFESABundle\Entity\DAF $cntDaf
     * @return DCont
     */
    public function setCntDaf(\CEOFESABundle\Entity\DAF $cntDaf = null)
    {
        $this->cntDaf = $cntDaf;

        return $this;
    }

    /**
     * Get cntDaf
     *
     * @return \CEOFESABundle\Entity\DAF
     */
    public function getCntDaf()
    {
        return $this->cntDaf;
    }

    /**
     * Set cntTiers
     *
     * @param \CEOFESABundle\Entity\Tiers $cntTiers
     * @return DCont
     */
    public function setCntTiers(\CEOFESABundle\Entity\Tiers $cntTiers = null)
    {
        $this->cntTiers = $cntTiers;

        return $this;
    }

    /**
     * Get cntTiers
     *
     * @return \CEOFESABundle\Entity\Tiers 
     */
    public function getCntTiers()
    {
        return $this->cntTiers;
    }

    /**
     * Set cntMotifsortie
     *
     * @param \CEOFESABundle\Entity\SortieT $cntMotifsortie
     * @return DCont
     */
    public function setCntMotifsortie(\CEOFESABundle\Entity\SortieT $cntMotifsortie = null)
    {
        $this->cntMotifsortie = $cntMotifsortie;

        return $this;
    }

    /**
     * Get cntMotifsortie
     *
     * @return \CEOFESABundle\Entity\SortieT
     */
    public function getCntMotifsortie()
    {
        return $this->cntMotifsortie;
    }
}
