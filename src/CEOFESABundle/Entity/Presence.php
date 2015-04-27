<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Presence
 *
 * @ORM\Table(name="tb_Presence", uniqueConstraints={@ORM\UniqueConstraint(name="unq_presence", columns={"psc_Session", "psc_Parcours"})})
 * @ORM\Entity
 */
class Presence
{
    /**
     * @var integer
     *
     * @ORM\Column(name="psc_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pscId;

    /**
     * @var \Session
     *
     * @ORM\ManyToOne(targetEntity="Session")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="psc_Session", referencedColumnName="ses_ID", nullable=false)
     * })
     */
    private $pscSession;

    /**
     * @var \Parcours
     *
     * @ORM\ManyToOne(targetEntity="Parcours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="psc_Parcours", referencedColumnName="prc_ID", nullable=false)
     * })
     */
    private $pscParcours;

    /**
     * @var string
     *
     * @ORM\Column(name="psc_Duree", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $pscDuree;

    /**
     * @var boolean
     *
     * @ORM\Column(name="psc_Facture", type="boolean", nullable=false, options={"default" = 0})
     */
    private $pscFacture;



    /**
     * Get pscId
     *
     * @return integer 
     */
    public function getPscId()
    {
        return $this->pscId;
    }

    /**
     * Set pscDuree
     *
     * @param string $pscDuree
     * @return Presence
     */
    public function setPscDuree($pscDuree)
    {
        $this->pscDuree = $pscDuree;

        return $this;
    }

    /**
     * Get pscDuree
     *
     * @return string 
     */
    public function getPscDuree()
    {
        return $this->pscDuree;
    }

    /**
     * Set pscFacture
     *
     * @param boolean $pscFacture
     * @return Presence
     */
    public function setPscFacture($pscFacture)
    {
        $this->pscFacture = $pscFacture;

        return $this;
    }

    /**
     * Get pscFacture
     *
     * @return boolean 
     */
    public function getPscFacture()
    {
        return $this->pscFacture;
    }

    /**
     * Set pscParcours
     *
     * @param \CEOFESABundle\Entity\Parcours $pscParcours
     * @return Presence
     */
    public function setPscParcours(\CEOFESABundle\Entity\Parcours $pscParcours = null)
    {
        $this->pscParcours = $pscParcours;

        return $this;
    }

    /**
     * Get pscParcours
     *
     * @return \CEOFESABundle\Entity\Parcours 
     */
    public function getPscParcours()
    {
        return $this->pscParcours;
    }

    /**
     * Set pscSession
     *
     * @param \CEOFESABundle\Entity\Session $pscSession
     * @return Presence
     */
    public function setPscSession(\CEOFESABundle\Entity\Session $pscSession = null)
    {
        $this->pscSession = $pscSession;

        return $this;
    }

    /**
     * Get pscSession
     *
     * @return \CEOFESABundle\Entity\Session 
     */
    public function getPscSession()
    {
        return $this->pscSession;
    }
}