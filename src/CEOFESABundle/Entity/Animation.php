<?php

namespace CEOFESABundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Animation
 *
 * @ORM\Table(name="tb_Animation", indexes={@ORM\Index(name="unq_animation", columns={"ani_Session", "ani_Tiers"})})
 * @ORM\Entity(repositoryClass="CEOFESABundle\Repository\AnimationRepository")
 */
class Animation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ani_ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $aniId;

    /**
     * @var Session
     *
     * @ORM\ManyToOne(
     *     targetEntity = "CEOFESABundle\Entity\Session",
     *     inversedBy   = "sesAnimations"
     * )
     *
     * @ORM\JoinColumn(
     *     name                 = "ani_Session",
     *     referencedColumnName = "ses_ID",
     *     nullable             = false
     * )
     */
    private $aniSession;

    /**
     * @var Tiers
     *
     * @ORM\ManyToOne(targetEntity = "CEOFESABundle\Entity\Tiers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(
     *     name                 = "ani_Tiers",
     *     referencedColumnName = "trs_ID",
     *     nullable             = false
     *     )
     * })
     */
    private $aniTiers;

    /**
     * Get aniId
     *
     * @return integer
     */
    public function getAniId()
    {
        return $this->aniId;
    }

    /**
     * Set aniTiers
     *
     * @param \CEOFESABundle\Entity\Tiers $aniTiers
     * 
     * @return Animation
     */
    public function setAniTiers(Tiers $aniTiers = null)
    {
        $this->aniTiers = $aniTiers;

        return $this;
    }

    /**
     * Get aniTiers
     *
     * @return \CEOFESABundle\Entity\Tiers
     */
    public function getAniTiers()
    {
        return $this->aniTiers;
    }

    /**
     * Set aniSession
     *
     * @param \CEOFESABundle\Entity\Session $aniSession
     * 
     * @return Animation
     */
    public function setAniSession(Session $aniSession = null)
    {
        $this->aniSession = $aniSession;

        return $this;
    }

    /**
     * Get aniSession
     *
     * @return \CEOFESABundle\Entity\Session
     */
    public function getAniSession()
    {
        return $this->aniSession;
    }
}
